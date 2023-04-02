<?php

namespace Sophy\Helpers;

trait Fillable
{
    private function fill($data)
    {
        foreach ($this->fillable as $field) {
            if (count($data)) {
                if (array_key_exists($field, $data)) {
                    $this->$field = $data[$field];
                }
            }

        }
    }
}
