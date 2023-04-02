<?php

namespace App\Objectbase\Application\Services;

use App\Objectbase\Domain\Entities\Objectbase;

final class UpdateService extends Base
{
    public function update($input, $objectbaseId)
    {
        $objectbaseToPrepared = new Objectbase($input);
        $objectbaseToPrepared->setObjectbase_id($objectbaseId);
        return $this->objectbaseRepository->save($objectbaseToPrepared);
    }

}

?>