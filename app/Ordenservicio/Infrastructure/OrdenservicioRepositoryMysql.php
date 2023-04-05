<?php

namespace App\Ordenservicio\Infrastructure;

use App\Ordenservicio\Domain\Entities\Ordenservicio;
use App\Ordenservicio\Domain\IOrdenservicioRepository;
use Slim\Exception\HttpNotFoundException;
use Sophy\Infrastructure\BaseRepositoryMysql;

class OrdenservicioRepositoryMysql extends BaseRepositoryMysql implements IOrdenservicioRepository
{
    /**
     * {@inheritdoc}
     */
    public function checkAndGetOrdenservicioOrFail(int $id): Ordenservicio
    {

        $ordenservicio = $this->where('ordenservicio_id', $id)->getOne();

        if (!$ordenservicio) {
            throw new HttpNotFoundException(null, 'No se encontró el ordenservicio con id: ' . $id . '.');
        }

        return $ordenservicio;
    }
}
