<?php

return [
    'boot' => [
        Sophy\Providers\ServerServiceProvider::class,
    ],
    'runtime' => [
        App\Providers\RouteServiceProvider::class,
        App\Providers\RepositoryServiceProvider::class,
    ],
    'cli' => [
    ]
];
