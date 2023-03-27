<?php

use App\DefaultAction;
use Sophy\Routing\Route;

Route::get('/', DefaultAction::class);

Route::group('/api', function ($group) {
});