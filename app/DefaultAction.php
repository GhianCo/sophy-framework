<?php

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Sophy\Application\Actions\Action;

class DefaultAction extends Action
{
    const API_VERSION = '1.0.0';

    protected function action(): Response
    {
        $appDomain = config('app.domain');

        $endpoints = [];
        $data = [
            'endpoints' => $endpoints,
            'version' => self::API_VERSION,
            'timestamp' => time()
        ];
        return $this->respondWithData($data, 'Data Services');
    }
}

?>