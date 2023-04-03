<?php

namespace App\Objectbase\Infrastructure;

use App\Objectbase\Domain\Entities\Objectbase;
use App\Objectbase\Domain\Exceptions\ObjectbaseException;
use App\Objectbase\Domain\IObjectbaseRepository;
use Sophy\Infrastructure\BaseRepositoryMysql;

class ObjectbaseRepositoryMysql extends BaseRepositoryMysql implements IObjectbaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function checkAndGetObjectbaseOrFail(int $id): Objectbase
    {

        $objectbase = $this->where('objectbase_id', $id)->getOne();

        if (!$objectbase) {
            throw new ObjectbaseException('No se encontró el objectbase con id: ' . $id . '.', 404);
        }

        return $objectbase;
    }
}
