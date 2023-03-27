<?php 

namespace App\Client\Application\Services;

use App\Client\Domain\Entities\Client;
use App\Client\Domain\Exceptions\ClientException;
use App\Utils\FieldValidator;
use App\Utils\GenericUtils;

final class CreateService extends Base
{

    use FieldValidator;

    private $fieldsRequired = array();

    public function create($input)
    {
        $resquestBody = $this->validateClientData($input);
        $client = new Client($resquestBody);

        $clientId = $this->clientRepository->insert($client);
        $client->setClient_id($clientId);

        return $client;
    }

    private function validateClientData($input)
    {
        $fieldsException = $this->validator($input);

        if (count($fieldsException)) {
            throw new ClientException('El/los campos ' . GenericUtils::arrayValuesToString($fieldsException, ", ") . ' son requerido(s).', 400);
        }

        return $input;
    }
}
?>