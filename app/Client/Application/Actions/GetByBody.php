<?php

namespace App\Client\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;

class GetByBody extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $client = $this->getFindService()->searchByParams($input);

        return $this->respondWithData($client['data'], 'Lista de clientes por body', $client['pagination']);
    }
}
