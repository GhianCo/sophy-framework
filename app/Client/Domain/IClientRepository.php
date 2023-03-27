<?php

namespace App\Client\Domain;

use App\Client\Domain\Entities\Client;
use Sophy\Domain\BaseRepository;

interface IClientRepository extends BaseRepository
{
    public function checkAndGetClientOrFail(int $id): Client;

    public function getClientByFB(int $id): Client;
}
