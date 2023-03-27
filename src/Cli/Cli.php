<?php

namespace Sophy\Cli;

use DI\ContainerBuilder;
use Sophy\App;
use Dotenv\Dotenv;
use Sophy\Cli\Commands\MakeModule;
use Sophy\Config\Config;
use Sophy\Database\Drivers\IDBDriver;
use Symfony\Component\Console\Application;

class Cli
{
    public static function bootstrap(string $root): self
    {
        App::$root = $root;

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);

        App::$container = $containerBuilder->build();

        Dotenv::createImmutable($root)->load();
        Config::load($root . "/config");

        foreach (config("providers.cli") as $provider) {
            (new $provider())->registerServices();
        }

        app(IDBDriver::class)->connect(
            config("database.driver"),
            config("database.host"),
            config("database.port"),
            config("database.name"),
            config("database.username"),
            config("database.password"),
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

    public function run()
    {
        $cli = new Application("Sophy");

        $cli->addCommands([
            new MakeModule(),
        ]);

        $cli->run();
    }
}