<?php

namespace App\Client;

use App\Client\Application\Actions\Create;
use App\Client\Application\Actions\GetAll;
use App\Client\Application\Actions\Update;
use App\Client\Application\Actions\GetOne;
use App\Client\Application\Actions\GetByQuery;
use App\Client\Application\Actions\GetByBody;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Client\Application\Actions\CreateClientValidator;

class ClientRoutes
{
    public static function group($group)
    {
        $group->group('/client', function (Group $group) {
            $group->get('', GetAll::class);
            $group->get('/byQuery', GetByQuery::class);
            $group->get('/{id}', GetOne::class);

            $group->post('', Create::class)->add(CreateClientValidator::class);
            $group->post('/byBody', GetByBody::class);

            $group->put('/{id}', Update::class);
        });
    }
}

?>