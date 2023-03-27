<?php

namespace App\Client\Application\Services;

use App\Client\Application\DTO\ClientDTO;
use App\Client\Domain\Entities\Client;
use App\Client\Domain\IClientRepository;
use Sophy\Application\Services\BaseService;

abstract class Base extends BaseService
{
    protected IClientRepository $clientRepository;

    public function __construct(IClientRepository $clientRepository)
    {
        parent::__construct();
        $this->clientRepository = $clientRepository;
        $this->config->registerMapping(Client::class, ClientDTO::class);
    }

    protected function getClientFromDb($clientId)
    {
        return $this->clientRepository->checkAndGetClientOrFail($clientId);
    }
}
