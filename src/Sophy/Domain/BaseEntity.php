<?php

namespace Sophy\Domain;

use Sophy\Helpers\Fillable;

abstract class BaseEntity {
    use Fillable;

    protected $fillable = [];

    public function __construct(array $data = null) {
        if (isset($data)) {
            $this->fill($data);
        }
    }

    public function getFillable() {
        return $this->fillable;
    }

    public function getAttribute($key) {
        if (!$this->keyHasValid($key)) {
            return false;
        }
        return $this->{$key};
    }

    public function setAttribute($key, $value) {
        $this->{$key} = $value;
        return $this;
    }

    public function keyHasValid($key) {
        if (!$key || !isset($this->{$key})) {
            return false;
        }
        return true;
    }
}
