<?php

use App\DefaultAction;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Sophy\Routing\Route;

Route::get('/', DefaultAction::class);

Route::group('/api', function (Group $group) {
});