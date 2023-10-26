<?php

namespace Sophy\Database\Drivers\Mysql;

trait DeleteClause {
    use ProcessClause;

    public function deleteRow() {
        $this->setAction('delete');
        $this->clearSource('SELECT');
        $this->clearSource('DISTINCT');
        $this->clearSource('FROM');
        $query = $this->makeDeleteQueryString();
        return $this->execute($query, $this->params);
    }

    public function truncate() {
        return $this->execute("TRUNCATE `$this->table`");
    }
}
