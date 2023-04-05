<?php

namespace App\Ordenservicio\Application\Services;

use App\Ordenservicio\Domain\IOrdenservicioRepository;
use Sophy\Application\Services\BaseService;
use App\Ordenservicio\Application\DTO\OrdenservicioDTO;
use App\Ordenservicio\Domain\Entities\Ordenservicio;

abstract class Base extends BaseService
{
    protected IOrdenservicioRepository $ordenservicioRepository;

    public function __construct(IOrdenservicioRepository $ordenservicioRepository)
    {
        parent::__construct();
        $this->ordenservicioRepository = $ordenservicioRepository;
        $this->config->registerMapping(Ordenservicio::class, OrdenservicioDTO::class);
    }

    protected function getOrdenservicioFromDb($ordenservicioId)
    {
        return $this->ordenservicioRepository->checkAndGetOrdenservicioOrFail($ordenservicioId);
    }
}
