<?php

namespace App\Client\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;

class GetAll extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $queryParams = $this->request->getQueryParams();
        $page = isset($queryParams['page']) ? $queryParams['page'] : null;
        $perPage = isset($queryParams['perPage']) ? $queryParams['perPage'] : null;

        $client = $this->getFindService()->getClientesByPage((int)$page, (int)$perPage);

        return $this->respondWithData($client['data'], 'Lista de clientes', $client['pagination']);
    }
}
