<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\FindService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;

class GetOne extends Action
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
        $objectbaseId = (int)$this->resolveArg('id');
        $objectbase = $this->findService->getObjectbase($objectbaseId);

        return $this->respondWithData($objectbase);
    }
}
