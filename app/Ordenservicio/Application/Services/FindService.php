<?php

namespace App\Ordenservicio\Application\Services;

use Sophy\Constants;
use App\Ordenservicio\Application\DTO\OrdenservicioDTO;

final class FindService extends Base
{
    public function getOrdenservicioesByPage($page, $perPage)
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($perPage < 1) {
            $perPage = self::DEFAULT_PER_PAGE_PAGINATION;
        }

        $ordenservicioResult = $this->ordenservicioRepository->paginate($page, $perPage);

        return array('data'=> $ordenservicioResult['data'], 'pagination' => $ordenservicioResult['pagination']);
    }

    public function getAll()
    {
        return $this->ordenservicioRepository->get();
    }

    public function getOrdenservicio($ordenservicioId)
    {
        return $this->getOrdenservicioFromDb($ordenservicioId);
    }

    public function getBySearch($querySearch)
    {
        if ($querySearch != Constants::UNDEFINED) {
        }

        return $this->ordenservicioRepository->get()['data'];
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

        $providers = $this->ordenservicioRepository->get();

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