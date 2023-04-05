<?php

namespace App\Ordenservicio\Application\Actions;

use App\Ordenservicio\Application\Services\UpdateService;
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
        $ordenservicioId = (int)$this->resolveArg('id');

        $ordenservicio = $this->updateService->update($input, $ordenservicioId);

        return $this->respondWithData($ordenservicio, 'Ordenservicio actualizado con éxito');
    }

}
