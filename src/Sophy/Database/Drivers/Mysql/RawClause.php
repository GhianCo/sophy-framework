<?php

namespace Sophy\Database\Drivers\Mysql;

class RawClause {
    protected $params = [];
    protected $query;

    public function setRawData($query, array $values) {
        $this->query = $query;
        $this->params = $values;
    }

    public function getRawQuery() {
        return $this->query;
    }

    public function getRawValues() {
        return $this->params;
    }
}
