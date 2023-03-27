<?php


namespace Sophy\Providers;

use Sophy\App;
use Sophy\Server\IServer;
use Sophy\Server\PhpNativeServer;

class ServerServiceProvider implements IServiceProvider
{
    public function registerServices()
    {
        App::$container->set(IServer::class, \DI\get(PhpNativeServer::class));
    }
}
