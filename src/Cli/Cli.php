<?php

namespace Sophy\Cli;

use Sophy\App;
use Dotenv\Dotenv;
use Sophy\Cli\Commands\MakeModule;
use Sophy\Config\Config;
use Symfony\Component\Console\Application;

class Cli
{
    public static function bootstrap(string $root): self
    {
        App::$root = $root;
        Dotenv::createImmutable($root)->load();
        Config::load($root . "/config");

        foreach (config("providers.cli") as $provider) {
            (new $provider())->registerServices();
        }

        /*
        app(DatabaseDriver::class)->connect(
            config("database.connection"),
            config("database.host"),
            config("database.port"),
            config("database.database"),
            config("database.username"),
            config("database.password"),
            );

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