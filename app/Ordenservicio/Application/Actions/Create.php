<?php

namespace App\Ordenservicio\Application\Actions;

use App\Ordenservicio\Application\Services\CreateService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;

class Create extends Action
{
    private $createService;

    public function __construct(CreateService $createService)
    {
        $this->createService = $createService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $ordenservicio = $this->createService->create($input);

        return $this->respondWithData($ordenservicio, 'Ordenservicio creado con éxito');
    }
}
