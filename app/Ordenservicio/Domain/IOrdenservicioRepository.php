<?php

namespace App\Ordenservicio\Domain;

use App\Ordenservicio\Domain\Entities\Ordenservicio;
use Sophy\Domain\BaseRepository;

interface IOrdenservicioRepository extends BaseRepository
{
    public function checkAndGetOrdenservicioOrFail(int $id): Ordenservicio;
}
