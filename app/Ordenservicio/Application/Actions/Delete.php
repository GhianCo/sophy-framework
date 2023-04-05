<?php

namespace App\Ordenservicio\Application\Actions;

use App\Ordenservicio\Application\Services\DeleteService;
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
        $ordenservicioId = (int)$this->resolveArg('id');
        $ordenservicio = $this->deleteService->delete((int)$ordenservicioId);

        return $this->respondWithData($ordenservicio, 'Ordenservicio eliminado con éxito');
    }
}

?>