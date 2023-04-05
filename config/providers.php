<?php

return [
    'boot' => [
        Sophy\Providers\DatabaseDriverServiceProvider::class,
    ],
    'runtime' => [
        App\Providers\RouteServiceProvider::class,
        App\Providers\RepositoryServiceProvider::class,
        App\Providers\ValidatorServiceProvider::class,
    ],
    'cli' => [
        Sophy\Providers\DatabaseDriverServiceProvider::class,
    ]
];
