<?php

namespace App\Providers;

use Sophy\App;
use Sophy\Providers\IServiceProvider;
use App\Ordenservicio\Domain\IOrdenservicioRepository;
use App\Ordenservicio\Infrastructure\OrdenservicioRepositoryMysql;

class RepositoryServiceProvider implements IServiceProvider
{
    public function registerServices()
    {
        App::$container->set(IOrdenservicioRepository::class, \DI\autowire(OrdenservicioRepositoryMysql::class)->method('setTable', 'ordenservicio'));
    }
}
