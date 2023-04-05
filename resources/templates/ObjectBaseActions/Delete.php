<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\DeleteService;
use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;

class Delete extends Action
{
    private $deleteService;

    public function __construct(DeleteService $deleteService)
    {
        $this->deleteService = $deleteService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $objectbaseId = (int)$this->resolveArg('id');
        $objectbase = $this->deleteService->delete((int)$objectbaseId);

        return $this->respondWithData($objectbase, 'Objectbase eliminado con éxito');
    }
}

?>