<?php

use App\DefaultAction;
use Sophy\Routing\Route;
use App\Ordenservicio\OrdenservicioRoutes;

Route::get('/', DefaultAction::class);

Route::group('/api', function ($group) {
    OrdenservicioRoutes::group($group);
});