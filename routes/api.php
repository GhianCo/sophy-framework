<?php

use App\DefaultAction;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Sophy\Routing\Route;
use App\Client\ClientRoutes;
use Sophy\Middleware\SessionMiddleware;

Route::get('/', DefaultAction::class);

Route::group('/api', function (Group $group) {
    ClientRoutes::group($group);
});//->add(SessionMiddleware::class);
