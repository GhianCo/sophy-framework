<?php 

namespace App\Ordenservicio\Application\Services;

use App\Ordenservicio\Domain\Entities\Ordenservicio;

final class CreateService extends Base
{
    public function create($input)
    {
        $ordenservicio = new Ordenservicio($input);
        return $this->ordenservicioRepository->save($ordenservicio);
    }
}
?>