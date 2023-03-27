<?php

namespace Sophy\Providers;

use Sophy\App;
use Sophy\Database\Drivers\IDBDriver;
use Sophy\Database\Drivers\PdoDriver;

class DatabaseDriverServiceProvider implements IServiceProvider
{

    public function registerServices()
    {
        switch (config('database.driver', 'mysql')) {
            case 'mysql' || 'pgsql':
                App::$container->set(IDBDriver::class, \DI\get(PdoDriver::class));
                break;
            default:
                App::$container->set(IDBDriver::class, \DI\get(PdoDriver::class));
                break;
        }
    }
}