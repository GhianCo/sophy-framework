<?php

namespace App\Objectbase\Application\Actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sophy\Validation\Validator;

final class CreateValidator implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $validator = new Validator($request);
        //$validator->rule('required', 'name_field');
        return ($validator)($request, $handler);
    }
}