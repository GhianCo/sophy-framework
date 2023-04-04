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
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

class ObjectbaseRoutes
{
    public static function group($group)
    {
        $group->group('/objectbase', function (Group $group) {
            $group->get('', GetAll::class);
            $group->get('/byQuery', GetByQuery::class);
            $group->get('/{id}', GetOne::class);

            $group->post('', Create::class)->add(CreateValidator::class);
            $group->post('/byBody', GetByBody::class);

            $group->put('/{id}', Update::class);
            $group->delete('/{id}', Delete::class);
        });
    }
}

?>