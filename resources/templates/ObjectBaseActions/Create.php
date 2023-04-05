<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\CreateService;
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
        $objectbase = $this->createService->create($input);

        return $this->respondWithData($objectbase, 'Objectbase creado con éxito');
    }
}
