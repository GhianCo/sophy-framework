<?php

namespace App\Client\Application\Services;

use App\Client\Domain\Entities\Client;
use App\Client\Domain\Exceptions\ClientException;
use App\Utils\FieldValidator;
use App\Utils\GenericUtils;

final class UpdateService extends Base
{

    use FieldValidator;

    private $fieldsRequired = array('client_id');

    public function update($input, $clientId)
    {
        $resquestBody = $this->validateClientData($input, $clientId);
        $clientToPrepared = new Client($resquestBody);

        $this->clientRepository->update($clientToPrepared);

        return $clientToPrepared;
    }

    private function validateClientData($input, $clientId)
    {
        $fieldsException = $this->validator($input);

        if (count($fieldsException)) {
            throw new ClientException('El/los campos ' . GenericUtils::arrayValuesToString($fieldsException, ", ") . ' son requerido(s).', 400);
        }

        $this->clientRepository->checkAndGetClientOrFail($clientId);

        return $input;
    }
}

?>