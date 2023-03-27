<?php

namespace App\Client\Infrastructure;

use App\Client\Domain\Entities\Client;
use App\Client\Domain\Exceptions\ClientException;
use App\Client\Domain\IClientRepository;
use Sophy\Infrastructure\BaseRepositoryMysql;

class ClientRepositoryMysql extends BaseRepositoryMysql implements IClientRepository
{
    /**
     * {@inheritdoc}
     */
    public function checkAndGetClientOrFail(int $id): Client
    {

        $whereParams = array(
            array("field" => "client_id", "value" => $id, "operator" => "=")
        );

        $client = $this->setWhereParams($whereParams)->execQueryRow();

        if (!$client) {
            throw new ClientException('No se encontró el client con id: ' . $id . '.', 404);
        }

        return $client;
    }

    public function getClientByFB(int $fbid): Client {

        $whereParams = array(
            array("field" => "fid", "value" => $fbid, "operator" => "=")
        );

        $client = $this->setWhereParams($whereParams)->execQueryRow();

        if (!$client) {
            throw new ClientException('No se encontró el cliente.', 404);
        }

        return $client;

    }
}
