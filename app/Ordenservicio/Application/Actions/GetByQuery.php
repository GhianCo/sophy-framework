<?php

namespace App\Ordenservicio\Application\Actions;

use App\Ordenservicio\Application\Services\FindService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;
use Sophy\Constants;

class GetByQuery extends Action
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
        $querySearch = isset($queryParams['q']) ? $queryParams['q'] : Constants::UNDEFINED;

        $ordenservicio = $this->findService->getBySearch($querySearch);

        return $this->respondWithData($ordenservicio, 'Lista de ordenservicioes por query');
    }
}
