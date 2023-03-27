<?php


namespace Sophy\Providers;

use Sophy\Server\IServer;
use Sophy\Server\PhpNativeServer;

class ServerServiceProvider implements IServiceProvider
{
    public function registerServices()
    {
        singleton(IServer::class, PhpNativeServer::class);
    }
}
