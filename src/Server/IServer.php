<?php

namespace Sophy\Server;

use Slim\Psr7\Request;

interface IServer
{
    public function getRequest(): Request;
}
