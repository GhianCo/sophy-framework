<?php

namespace Sophy\Database\Drivers\Mysql;

use Sophy\Database\Drivers\Interfaces\ISelectQueryBuilder;

class SelectQueryBuilder implements ISelectQueryBuilder {
    private $withCallFoundRows = false;

    private $fields = [];

    private $conditions = [];

    private $order = [];

    private $table = [];

    private $innerJoin = [];

    private $leftJoin = [];

    private $rightJoin = [];

    private $limit = '';

    public function __construct(string $table, array $fields) {
        $this->table = $table;
        $this->fields = $fields;
    }

    public function select(string ...$select): ISelectQueryBuilder {
        foreach ($select as $arg) {
            $this->fields[] = $arg;
        }
        return $this;
    }

    public function callFoundRows(bool $withCallFoundRows): ISelectQueryBuilder {
        $this->withCallFoundRows = $withCallFoundRows;
        return $this;
    }

    public function where($conditions): ISelectQueryBuilder {
        $this->conditions = $conditions;
        return $this;
    }

    public function whereColumn($field, $operator = '=', $contional = ''): ISelectQueryBuilder {
        $this->conditions[] = sprintf(' %s %s :%s %s', $field, $operator, $field, $contional);
        return $this;
    }

    public function first(): ISelectQueryBuilder {
        $this->limit = ' limit 1 ';
        return $this;
    }

    public function page(int $page): ISelectQueryBuilder {
        $this->limit .= ' limit ' . $page;
        return $this;
    }

    public function perPage(int $perPage): ISelectQueryBuilder {
        $this->limit .= ', ' . $perPage;
        return $this;
    }

    public function orderBy(string ...$order): ISelectQueryBuilder {
        foreach ($order as $arg) {
            $this->order[] = $arg;
        }
        return $this;
    }

    public function innerJoin(string ...$innerJoin): ISelectQueryBuilder {
        foreach ($innerJoin as $arg) {
            $this->innerJoin[] = $arg;
        }
        return $this;
    }

    public function leftJoin(string ...$leftJoin): ISelectQueryBuilder {
        foreach ($leftJoin as $arg) {
            $this->leftJoin[] = $arg;
        }
        return $this;
    }

    public function rightJoin(string ...$rightJoin): ISelectQueryBuilder {
        foreach ($rightJoin as $arg) {
            $this->rightJoin[] = $arg;
        }
        return $this;
    }


    public function __toString(): string {
        return 'SELECT ' . ($this->withCallFoundRows ? ' SQL_CALC_FOUND_ROWS ' : ' ') . implode(', ', $this->fields)
            . ' FROM ' . $this->table
            . ($this->innerJoin === [] ? '' : ' INNER JOIN ' . implode(' INNER JOIN ', $this->innerJoin))
            . ($this->leftJoin === [] ? '' : ' LEFT JOIN ' . implode(' LEFT JOIN ', $this->leftJoin))
            . ($this->rightJoin === [] ? '' : ' RIGHT JOIN ' . implode(' RIGHT JOIN ', $this->rightJoin))
            . ($this->conditions === [] ? '' : ' WHERE ' . implode(' ', $this->conditions))
            . ($this->order === [] ? '' : ' ORDER BY ' . implode(', ', $this->order))
            . ($this->limit == '' ? '' : $this->limit);
    }
}
