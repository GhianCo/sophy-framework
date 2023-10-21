<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\FindService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;
use Sophy\Helpers\Constants;

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
        $querySearch = isset($queryParams['q']) ? $queryParams['q'] : Constants::PARAM_UNDEFINED;

        $objectbase = $this->findService->getBySearch($querySearch);

        return $this->respondWithData($objectbase, 'Lista de objectbasees por query');
    }
}
