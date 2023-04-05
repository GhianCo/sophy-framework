<?php

namespace App\Ordenservicio\Application\Services;

final class DeleteService extends Base
{
    public function delete($id)
    {
        $ordenservicioStored = $this->getOrdenservicioFromDb($id);
        $this->ordenservicioRepository->delete($ordenservicioStored);
        return $ordenservicioStored;
    }
}

?>