<?php

namespace Sophy;

use DI\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\ServerRequestCreatorFactory;
use Sophy\Config\Config;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Sophy\Application\Handlers\HttpErrorHandler;
use Sophy\Application\Handlers\ShutdownHandler;
use Sophy\Application\ResponseEmitter\ResponseEmitter;
use Sophy\Database\Drivers\IDBDriver;
use Slim\Factory\AppFactory;
use Slim\App as Router;

class App
{
    public static string $root;

    public static Container $container;

    public IDBDriver $database;

    public Request $request;

    public Router $router;

    public static function bootstrap(string $root): self
    {
        self::$root = $root;

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);

        self::$container = $containerBuilder->build();

        $app = app(self::class);

        return $app
            ->loadConfig()
            ->runServiceProviders('boot')
            ->setHttpHandlers()
            ->cors()
            ->setUpDatabaseConnection()
            ->runServiceProviders('runtime');
    }

    protected function loadConfig(): self
    {
        Dotenv::createImmutable(self::$root)->load();
        Config::load(self::$root . "/config");

        return $this;
    }

    protected function runServiceProviders(string $type): self
    {
        foreach (config("providers.$type", []) as $provider) {
            (new $provider())->registerServices();
        }

        return $this;
    }

    protected function setHttpHandlers(): self
    {
        $this->router = singleton(Router::class, function () {
            AppFactory::setContainer(self::$container);
            $router = AppFactory::create();
            $router->setBasePath(config("app.pathRoute"));
            return $router;
        });

        $this->request = singleton(Request::class, function () {
            $serverRequestCreator = ServerRequestCreatorFactory::create();
            return $serverRequestCreator->createServerRequestFromGlobals();
        });

        return $this;
    }

    protected function cors()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header('Access-Control-Allow-Methods: PUT, GET, POST, OPTIONS, DELETE');
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
        }
        return $this;
    }

    protected function setUpDatabaseConnection(): self
    {
        $this->database = app(IDBDriver::class);

        $this->database->connect(
            config("database.driver"),
            config("database.host"),
            config("database.port"),
            config("database.name"),
            config("database.username"),
            config("database.password"),
            );

        return $this;
    }

    public function run()
    {
        $env = config('app.env');

        date_default_timezone_set(config('app.timezone', 'UTC'));

        // Create Error Handler
        $errorHandler = new HttpErrorHandler($this->router->getCallableResolver(), $this->router->getResponseFactory());

        // Create Shutdown Handler
        register_shutdown_function(new ShutdownHandler($this->request, $errorHandler, $env == 'dev'));

        // Add Routing Middleware
        $this->router->addRoutingMiddleware();

        // Add Body Parsing Middleware
        $this->router->addBodyParsingMiddleware();

        // Add Error Middleware
        $errorMiddleware = $this->router->addErrorMiddleware($env == 'dev', false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        // Run App & Emit Response
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($this->router->handle($this->request));
        $this->database->close();
    }
}
