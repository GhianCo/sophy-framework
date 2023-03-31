<?php

namespace Sophy\Domain;

abstract class BaseEntity {
    protected $fillable = [];

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
