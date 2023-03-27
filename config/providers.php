<?php

return [
    'boot' => [
        Sophy\Providers\ServerServiceProvider::class,
        Sophy\Providers\DatabaseDriverServiceProvider::class,
    ],
    'runtime' => [
        App\Providers\RouteServiceProvider::class,
        App\Providers\RepositoryServiceProvider::class,
    ],
    'cli' => [
    ]
];
