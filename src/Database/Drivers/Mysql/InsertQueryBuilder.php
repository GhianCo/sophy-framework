<?php

namespace Sophy\Database\Drivers\Mysql;

use Sophy\Database\Drivers\Interfaces\IInsertQueryBuilder;

class InsertQueryBuilder implements IInsertQueryBuilder {
    private $table;

    private $columns = [];

    private $values = [];

    public function __construct(string $table) {
        $this->table = $table;
    }

    public function columns(string ...$columns): IInsertQueryBuilder {
        foreach ($columns as $column) {
            $this->columns[] = $column;
            $this->values[] = ":$column";
        }
        return $this;
    }

    public function __toString(): string {
        return 'INSERT INTO ' . $this->table
            . ' (' . implode(', ', $this->columns) . ') VALUES (' . implode(', ', $this->values) . ')';
    }
}
