<?php

namespace App\Client\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;

class GetOne extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $clientId = (int)$this->resolveArg('id');
        $client = $this->getFindService()->getClient($clientId);

        return $this->respondWithData($client);
    }
}
