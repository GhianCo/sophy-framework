<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\FindService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;

class GetAll extends Action
{
    private $findService;

    public function __construct(FindService $findService)
    {
        $this->findService = $findService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $queryParams = $this->request->getQueryParams();
        $page = isset($queryParams['page']) ? $queryParams['page'] : null;
        $perPage = isset($queryParams['perPage']) ? $queryParams['perPage'] : null;

        $objectbase = $this->findService->getObjectbaseesByPage((int)$page, (int)$perPage);

        return $this->respondWithData($objectbase['data'], 'Lista de objectbasees', $objectbase['pagination']);
    }
}
