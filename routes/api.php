<?php

use App\DefaultAction;
use Sophy\Routing\Route;
use App\Client\ClientRoutes;

Route::get('/', DefaultAction::class);

Route::group('/api', function ($group) {
    ClientRoutes::group($group);
});