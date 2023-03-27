<?php

namespace Sophy\Database\Drivers\Mysql;

use Sophy\Database\Drivers\Interfaces\IUpdateQueryBuilder;

class UpdateQueryBuilder implements IUpdateQueryBuilder
{
    private $table;

    private $conditions = [];

    private $columns = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function where(string ...$where): IUpdateQueryBuilder
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function set(string ...$columns): IUpdateQueryBuilder
    {
        foreach ($columns as $column) {
            $this->columns[] = "$column = :$column";
        }
        return $this;
    }

    public function __toString(): string
    {
        return 'UPDATE ' . $this->table
            . ' SET ' . implode(', ', $this->columns)
            . ($this->conditions === [] ? '' : ' WHERE ' . implode(' ', $this->conditions));
    }
}