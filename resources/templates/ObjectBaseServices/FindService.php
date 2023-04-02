<?php

namespace App\Objectbase\Application\Services;

use Sophy\Constants;
use App\Objectbase\Application\DTO\ObjectbaseDTO;

final class FindService extends Base
{
    public function getObjectbaseesByPage($page, $perPage)
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($perPage < 1) {
            $perPage = self::DEFAULT_PER_PAGE_PAGINATION;
        }

        $objectbaseResult = $this->objectbaseRepository->paginate($page, $perPage);

        $objectbaseData = $this->mapper->mapMultiple($objectbaseResult['data'], ObjectbaseDTO::class);

        return array('data'=> $objectbaseData, 'pagination' => $objectbaseResult['pagination']);
    }

    public function getAll()
    {
        return $this->objectbaseRepository->get();
    }

    public function getObjectbase($objectbaseId)
    {
        return $this->getObjectbaseFromDb($objectbaseId);
    }

    public function getBySearch($querySearch)
    {
        if ($querySearch != Constants::UNDEFINED) {
        }

        return $this->objectbaseRepository->get()['data'];
    }

    public function searchByParams($input)
    {
        $requestBody = $this->validateParamsToSearch($input);
        $query = $requestBody->query;
        $active = $requestBody->active;
        $page = $requestBody->page;
        $perPage = $requestBody->perPage;

        if ($query != Constants::UNDEFINED) {}

        if ($active != Constants::UNDEFINED) {}

        $providers = $this->objectbaseRepository->get();

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