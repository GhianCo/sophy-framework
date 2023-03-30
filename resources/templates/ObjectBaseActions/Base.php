<?php

namespace App\Objectbase\Application\Actions;

use App\Objectbase\Application\Services\CreateService;
use App\Objectbase\Application\Services\FindService;
use App\Objectbase\Application\Services\UpdateService;
use Sophy\Application\Actions\Action;
use Sophy\Container\Container;

abstract class Base extends Action
{
    protected function getCreateService()
    {
        return Container::resolve(CreateService::class);
    }

    protected function getUpdateService()
    {
        return Container::resolve(UpdateService::class);
    }

    protected function getFindService(): FindService
    {
        return Container::resolve(FindService::class);
    }
}
