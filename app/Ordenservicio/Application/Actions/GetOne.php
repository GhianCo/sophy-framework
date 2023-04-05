<?php

namespace App\Ordenservicio\Application\Actions;

use App\Ordenservicio\Application\Services\FindService;
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
        $ordenservicioId = (int)$this->resolveArg('id');
        $ordenservicio = $this->findService->getOrdenservicio($ordenservicioId);

        return $this->respondWithData($ordenservicio);
    }
}
