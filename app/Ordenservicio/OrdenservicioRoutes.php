<?php

namespace App\Ordenservicio;

use App\Ordenservicio\Application\Actions\GetAll;
use App\Ordenservicio\Application\Actions\GetOne;
use App\Ordenservicio\Application\Actions\GetByQuery;
use App\Ordenservicio\Application\Actions\GetByBody;
use App\Ordenservicio\Application\Actions\Create;
use App\Ordenservicio\Application\Actions\Update;
use App\Ordenservicio\Application\Actions\Delete;
use App\Ordenservicio\Application\Actions\CreateValidator;

class OrdenservicioRoutes
{
    public static function group($routeGroup)
    {
        $routeGroup->group('/ordenservicio', function ($route) {
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