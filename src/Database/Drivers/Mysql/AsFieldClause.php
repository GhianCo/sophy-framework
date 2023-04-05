<?php

namespace Sophy\Database\Drivers\Mysql;

class AsFieldClause extends SelectFunctionsClause {
    protected $select;

    public function __construct(SelectFunctionsClause $select) {
        $this->select = $select;
    }

    public function as($value) {
        $end_index = count($this->select->stringArray) - 1;
        $this->select->stringArray[$end_index] = $this->select->stringArray[$end_index] . " as '$value'";
    }
}
