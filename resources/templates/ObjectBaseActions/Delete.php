<?php

namespace App\Client\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;

class Delete extends Base
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $objectbaseId = (int)$this->resolveArg('id');
        $objectbase = $this->getDeleteService()->delete((int)$objectbaseId);

        return $this->respondWithData($objectbase, 'Client eliminado con éxito');
    }
}

?>