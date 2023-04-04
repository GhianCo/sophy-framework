<?php

namespace App\Providers;

use Sophy\Providers\IServiceProvider;
use Valitron\Validator;

class ValidatorServiceProvider implements IServiceProvider
{
    public function registerServices()
    {
        singleton(Validator::class, function () {
            Validator::lang('es');
            return new Validator();
        });
    }
}