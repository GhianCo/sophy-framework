<?php 

namespace App\Objectbase\Application\Services;

use App\Objectbase\Domain\Entities\Objectbase;

final class CreateService extends Base
{
    public function create($input)
    {
        $objectbase = new Objectbase($input);
        return $this->objectbaseRepository->save($objectbase);
    }
}
?>