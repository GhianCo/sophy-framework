<?php

namespace App\Client\Application\Services;

use App\Client\Application\DTO\ClientDTO;
use Sophy\Constants;

final class FindService extends Base
{
    public function getClientesByPage($page, $perPage)
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($perPage < 1) {
            $perPage = self::DEFAULT_PER_PAGE_PAGINATION;
        }
        $criteria = array('page' => $page, 'perPage' => $perPage);

        $clientes = $this->clientRepository->fetchRowsByCriteria($criteria);

        $data = $this->mapper->mapMultiple($clientes['data'], ClientDTO::class);

        return array('data'=> $data, 'pagination' => $clientes['pagination']);
    }

    public function getAll()
    {
        return $this->clientRepository->fetchRowsByCriteria();
    }

    public function getClient($clientId)
    {
        return $this->getClientFromDb($clientId);
    }

    public function getBySearch($querySearch)
    {
        $whereParams = array();
        $orderParams = array();

        if ($querySearch != Constants::UNDEFINED) {
        }

        $criteria = array('whereParams' => $whereParams, 'orderParams' => $orderParams);

        return $this->clientRepository->fetchRowsByCriteria($criteria)['data'];

    }

    public function searchByParams($input)
    {
        $requestBody = $this->validateParamsToSearch($input);
        $query = $requestBody->query;
        $active = $requestBody->active;
        $page = $requestBody->page;
        $perPage = $requestBody->perPage;

        $whereParams = array();

        if ($query != Constants::UNDEFINED) {}

        if ($active != Constants::UNDEFINED) {}

        $orderParams = array();

        $criteria = array('whereParams' => $whereParams, 'orderParams' => $orderParams, 'page' => $page, 'perPage' => $perPage);

        $providers = $this->clientRepository->fetchRowsByCriteria($criteria);

        return $providers;
    }

    private function validateParamsToSearch($input)
    {
        $requestBody = json_decode((string)json_encode($input), false);

        if (!isset($requestBody->query)) {
            $requestBody->query = Constants::UNDEFINED;
        }

        if (!isset($requestBody->active)) {
            $requestBody->active = Constants::UNDEFINED;
        }

        if (!isset($requestBody->page)) {
            $requestBody->page = 1;
        }

        if (!isset($requestBody->perPage)) {
            $requestBody->perPage = self::DEFAULT_PER_PAGE_PAGINATION;
        }

        return $requestBody;
    }
}

?>