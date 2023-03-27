<?php

namespace App\Client\Application\Actions;

use App\Client\Application\Services\CreateService;
use App\Client\Application\Services\FindService;
use App\Client\Application\Services\UpdateService;
use Sophy\Application\Actions\Action;

abstract class Base extends Action
{
    protected function getCreateService()
    {
        return $this->container->get(CreateService::class);
    }

    protected function getUpdateService()
    {
        return $this->container->get(UpdateService::class);
    }

    protected function getFindService(): FindService
    {
        return $this->container->get(FindService::class);
    }
}
