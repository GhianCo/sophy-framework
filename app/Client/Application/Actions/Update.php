<?php

namespace App\Client\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;

class Update extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $clientId = (int)$this->resolveArg('id');

        $client = $this->getUpdateService()->update($input, $clientId);

        return $this->respondWithData($client, 'Client actualizado con éxito');
    }

}
