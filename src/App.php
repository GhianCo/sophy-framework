<?php

namespace Sophy;

use DI\Container;
use Slim\Factory\ServerRequestCreatorFactory;
use Sophy\Config\Config;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Psr7\Request;
use Sophy\Application\Handlers\HttpErrorHandler;
use Sophy\Application\Handlers\ShutdownHandler;
use Sophy\Application\ResponseEmitter\ResponseEmitter;
use Sophy\Database\Drivers\IDBDriver;
use Sophy\Server\IServer;
use Slim\Factory\AppFactory;
use Slim\App as Router;

class App
{

    public static string $root;

    public Router $router;

    public Request $request;

    public IServer $server;

    public static Container $container;

    public IDBDriver $database;

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
            $provider = new $provider();
            $provider->registerServices();
        }

        return $this;
    }

    protected function setHttpHandlers(): self
    {
        $this->router = singleton(Router::class, function () {
            AppFactory::setContainer(self::$container);
            $router = AppFactory::create();
            $router->setBasePath('/sophy-framework');
            return $router;
        });
        $this->server = app(IServer::class);
        $this->request = singleton(Request::class, function () {
            return $this->server->getRequest();
        });

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

        $callableResolver = $this->router->getCallableResolver();

        // Create Request object from globals
        $serverRequestCreator = ServerRequestCreatorFactory::create();
        $request = $serverRequestCreator->createServerRequestFromGlobals();

        // Create Error Handler
        $responseFactory = $this->router->getResponseFactory();
        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

        // Create Shutdown Handler
        $shutdownHandler = new ShutdownHandler($request, $errorHandler, $env == 'dev');
        register_shutdown_function($shutdownHandler);

        // Add Routing Middleware
        $this->router->addRoutingMiddleware();

        // Add Body Parsing Middleware
        $this->router->addBodyParsingMiddleware();

        // Add Error Middleware
        $errorMiddleware = $this->router->addErrorMiddleware($env == 'dev', false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        // Run App & Emit Response
        $response = $this->router->handle($request);
        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit($response);
    }
}