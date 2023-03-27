<?php

namespace App\Providers;

use Sophy\App;
use Sophy\Providers\IServiceProvider;
use Sophy\Routing\Route;

class RouteServiceProvider implements IServiceProvider
{
    public function registerServices()
    {
        Route::load(App::$root . "/routes");
    }
}
