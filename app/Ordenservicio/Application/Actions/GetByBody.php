<?php

namespace App\Ordenservicio\Application\Actions;

use App\Ordenservicio\Application\Services\FindService;
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
        $ordenservicio = $this->findService->searchByParams($input);

        return $this->respondWithData($ordenservicio['data'], 'Lista de ordenservicioes por body', $ordenservicio['pagination']);
    }
}
