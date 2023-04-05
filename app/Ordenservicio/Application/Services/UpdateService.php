<?php

namespace App\Ordenservicio\Application\Services;

use App\Ordenservicio\Domain\Entities\Ordenservicio;

final class UpdateService extends Base
{
    public function update($input, $ordenservicioId)
    {
        $ordenservicioToPrepared = new Ordenservicio($input);
        $ordenservicioToPrepared->setOrdenservicio_id($ordenservicioId);
        return $this->ordenservicioRepository->save($ordenservicioToPrepared);
    }

}

?>