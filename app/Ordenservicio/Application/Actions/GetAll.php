<?php

namespace App\Ordenservicio\Application\Actions;

use App\Ordenservicio\Application\Services\FindService;
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

        $ordenservicio = $this->findService->getOrdenservicioesByPage((int)$page, (int)$perPage);

        return $this->respondWithData($ordenservicio['data'], 'Lista de ordenservicioes', $ordenservicio['pagination']);
    }
}
