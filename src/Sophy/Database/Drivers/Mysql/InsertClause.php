<?php

namespace Sophy\Database\Drivers\Mysql;

trait InsertClause {
    use ProcessClause;

    protected function insert($values, $get_last_insert_id = false) {
        $this->setAction('insert');
        $query = $this->makeInsertQueryString($values);
        $result = $this->execute($query, $this->params);

        if (!$get_last_insert_id) {
            return $result;
        } else {
            return $this->driver->lastInsertId();
        }
    }

    protected function insertGetId($values) {
        return $this->insert($values, true);
    }
}
