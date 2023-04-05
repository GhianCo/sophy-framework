<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\UpdateService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;

class Update extends Action
{
    private $updateService;

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $objectbaseId = (int)$this->resolveArg('id');

        $objectbase = $this->updateService->update($input, $objectbaseId);

        return $this->respondWithData($objectbase, 'Objectbase actualizado con éxito');
    }

}
