<?php

namespace App\Client\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;

class Create extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $client = $this->getCreateService()->create($input);

        return $this->respondWithData($client, 'Client creado con éxito');
    }
}
