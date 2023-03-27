<?php 

namespace App\Client\Domain\Entities;

use Sophy\Domain\BaseEntity;

final class Client extends BaseEntity
{

    protected $fillable = [
        'client_id',
        'name',
        'lastname',
        'email',
        'phone',
        'gid',
        'fid',
        'aid',
        'code',
        'state',
        'postalCode',
        'createdBy',
        'created',
        'lastModifiedBy',
        'lastModified',
    ];

    public function setClient_id($client_id){ 
        $this->setAttribute('client_id', $client_id);
    }

    public function getClient_id(){ 
        return $this->getAttribute('client_id');
    }

    public function setName($name){ 
        $this->setAttribute('name', $name);
    }

    public function getName(){ 
        return $this->getAttribute('name');
    }

    public function setLastname($lastname){ 
        $this->setAttribute('lastname', $lastname);
    }

    public function getLastname(){ 
        return $this->getAttribute('lastname');
    }

    public function setEmail($email){ 
        $this->setAttribute('email', $email);
    }

    public function getEmail(){ 
        return $this->getAttribute('email');
    }

    public function setPhone($phone){ 
        $this->setAttribute('phone', $phone);
    }

    public function getPhone(){ 
        return $this->getAttribute('phone');
    }

    public function setGid($gid){ 
        $this->setAttribute('gid', $gid);
    }

    public function getGid(){ 
        return $this->getAttribute('gid');
    }

    public function setFid($fid){ 
        $this->setAttribute('fid', $fid);
    }

    public function getFid(){ 
        return $this->getAttribute('fid');
    }

    public function setAid($aid){ 
        $this->setAttribute('aid', $aid);
    }

    public function getAid(){ 
        return $this->getAttribute('aid');
    }

    public function setCode($code){ 
        $this->setAttribute('code', $code);
    }

    public function getCode(){ 
        return $this->getAttribute('code');
    }

    public function setState($state){ 
        $this->setAttribute('state', $state);
    }

    public function getState(){ 
        return $this->getAttribute('state');
    }

    public function setPostalCode($postalCode){ 
        $this->setAttribute('postalCode', $postalCode);
    }

    public function getPostalCode(){ 
        return $this->getAttribute('postalCode');
    }

    public function setCreatedBy($createdBy){ 
        $this->setAttribute('createdBy', $createdBy);
    }

    public function getCreatedBy(){ 
        return $this->getAttribute('createdBy');
    }

    public function setCreated($created){ 
        $this->setAttribute('created', $created);
    }

    public function getCreated(){ 
        return $this->getAttribute('created');
    }

    public function setLastModifiedBy($lastModifiedBy){ 
        $this->setAttribute('lastModifiedBy', $lastModifiedBy);
    }

    public function getLastModifiedBy(){ 
        return $this->getAttribute('lastModifiedBy');
    }

    public function setLastModified($lastModified){ 
        $this->setAttribute('lastModified', $lastModified);
    }

    public function getLastModified(){ 
        return $this->getAttribute('lastModified');
    }

}
?>