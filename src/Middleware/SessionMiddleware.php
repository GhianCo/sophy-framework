<?php

namespace Sophy\Middleware;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Sophy\Domain\Exceptions\AuthException;

class SessionMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $jwtHeader = $request->getHeaderLine('Authorization');
        $jwt_GET = isset($_GET["token"]) ? $_GET["token"] : false;
        if (!$jwtHeader && !$jwt_GET) {
            throw new AuthException('El token de autenticación es requerido.', 401);
        }
        if (!$jwtHeader && $jwt_GET) {
            $jwtHeader = 'Bearer ' . $jwt_GET;
        }
        $jwt = explode('Bearer ', $jwtHeader);
        if (!isset($jwt[1])) {
            throw new AuthException('El token de autenticación es inválido. Ejm: Bearer *token*.', 401);
        }
        $this->checkToken($jwt[1]);

        return $handler->handle($request);
    }

    protected function checkToken($token)
    {
        try {
            return JWT::decode($token, $_SERVER['SECRET_KEY'], ['HS256']);
        } catch (\UnexpectedValueException $e) {
            throw new AuthException('Acceso restringido: no tienes permisos para ver este recurso.', 403);
        }
    }
}
