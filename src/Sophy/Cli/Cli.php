<?php

namespace Sophy\Cli;

use DI\ContainerBuilder;
use Sophy\App;
use Dotenv\Dotenv;
use Sophy\Cli\Commands\MakeModule;
use Sophy\Config\Config;
use Sophy\Database\Drivers\IDBDriver;
use Symfony\Component\Console\Application;

class Cli {
    public static function bootstrap(string $root): self {
        App::$root = $root;

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);

        App::$container = $containerBuilder->build();

        Dotenv::createImmutable($root)->load();
        Config::load($root . "/config");

        foreach (config("providers.cli") as $provider) {
            (new $provider())->registerServices();
        }

        $defaultConnection = config("database.default");

        app(IDBDriver::class)->connect(
            config("database.connections." . $defaultConnection . ".driver"),
            config("database.connections." . $defaultConnection . ".host"),
            config("database.connections." . $defaultConnection . ".port"),
            config("database.connections." . $defaultConnection . ".name"),
            config("database.connections." . $defaultConnection . ".username"),
            config("database.connections." . $defaultConnection . ".password"),
        );
        /*
        singleton(
            Migrator::class,
            fn() => new Migrator(
            "$root/database/migrations",
            resourcesDirectory() . "/templates",
            app(DatabaseDriver::class)
        )
        );*/

        return new self();
    }

    public function run() {
        $cli = new Application("Sophy");

        $cli->addCommands([
            new MakeModule(),
        ]);

        $cli->run();
    }
}
