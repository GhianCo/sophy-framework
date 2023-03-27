<?php

namespace App\Providers;

use App\Client\Domain\IClientRepository;
use App\Client\Infrastructure\ClientRepositoryMysql;
use Sophy\App;
use Sophy\Providers\IServiceProvider;

class RepositoryServiceProvider implements IServiceProvider
{
    public function registerServices()
    {
        App::$container->set(IClientRepository::class, \DI\autowire(ClientRepositoryMysql::class)->method('setTable', 'client'));
    }
}
