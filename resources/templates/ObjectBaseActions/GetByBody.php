<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\FindService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;

class GetByBody extends Action
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
        $input = (array)$this->request->getParsedBody();
        $objectbase = $this->findService->searchByParams($input);

        return $this->respondWithData($objectbase['data'], 'Lista de objectbasees por body', $objectbase['pagination']);
    }
}
