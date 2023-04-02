<?php

namespace App\Objectbase\Application\Services;

final class DeleteService extends Base
{
    public function delete($id)
    {
        $objectbaseStored = $this->getObjectbaseFromDb($id);
        $this->objectbaseRepository->delete($objectbaseStored);
        return $objectbaseStored;
    }
}

?>