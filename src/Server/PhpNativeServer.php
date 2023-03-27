<?php

namespace Sophy\Server;

use Slim\Psr7\Cookies;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Factory\UriFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;
use Slim\Psr7\Stream;

class PhpNativeServer implements IServer
{

    /**
     * @inheritDoc
     */
    public function getRequest(): Request
    {
        $headers = Headers::createFromGlobals();
        $cookies = Cookies::parseHeader($headers->getHeader('Cookie', []));

        // Cache the php://input stream as it cannot be re-read
        $cacheResource = fopen('php://temp', 'wb+');
        $cache = $cacheResource ? new Stream($cacheResource) : null;

        $body = (new StreamFactory())->createStreamFromFile('php://input', 'r', $cache);

        return new Request(
            $_SERVER["REQUEST_METHOD"],
            $uri = (new UriFactory())->createFromGlobals($_SERVER),
            $headers,
            $cookies,
            $_SERVER,
            $body
        );
    }
}
