<?php

namespace App\Objectbase;

use App\Objectbase\Application\Actions\GetAll;
use App\Objectbase\Application\Actions\GetOne;
use App\Objectbase\Application\Actions\GetByQuery;
use App\Objectbase\Application\Actions\GetByBody;
use App\Objectbase\Application\Actions\Create;
use App\Objectbase\Application\Actions\Update;
use App\Objectbase\Application\Actions\Delete;
use App\Objectbase\Application\Actions\CreateValidator;

class ObjectbaseRoutes
{
    public static function group($routeGroup)
    {
        $routeGroup->group('/objectbase', function ($route) {
            $route->get('', GetAll::class);
            $route->get('/byQuery', GetByQuery::class);
            $route->get('/{id}', GetOne::class);

            $route->post('', Create::class)->add(CreateValidator::class);
            $route->post('/byBody', GetByBody::class);

            $route->put('/{id}', Update::class);
            $route->delete('/{id}', Delete::class);
        });
    }
}

?>