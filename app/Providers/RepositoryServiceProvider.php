<?php

namespace App\Providers;

use Sophy\App;
use Sophy\Providers\IServiceProvider;
use App\Client\Domain\IClientRepository;
use App\Client\Infrastructure\ClientRepositoryMysql;

class RepositoryServiceProvider implements IServiceProvider
{
    public function registerServices()
    {
        App::$container->set(IClientRepository::class, \DI\autowire(ClientRepositoryMysql::class)->method('setTable', 'client'));
    }
}
