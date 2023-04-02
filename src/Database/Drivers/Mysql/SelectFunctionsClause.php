<?php

namespace Sophy\Database\Drivers\Mysql;

class SelectFunctionsClause
{

    use ProcessClause;

    protected $builder;
    protected $stringArray = [];

    public function setTable($value)
    {
        $this->table = $value;
    }

    public function all($table)
    {
        $this->stringArray[] = "`$table`.*";
        return $this;
    }

    public function field($column)
    {
        $column = $this->fix_column_name($column)['name'];
        $this->stringArray[] = $column;
        return new AsFieldClause($this);
    }

    /**
     * Retrieve the "count" result of the query.
     *
     * @param string $columns
     * @return AsFieldClause
     */
    public function count($column = '*')
    {
        $this->fn("COUNT", $column);
        return new AsFieldClause($this);
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param string $column
     * @return mixed
     */
    public function sum($column = '*')
    {
        $this->fn("SUM", $column);
        return new AsFieldClause($this);
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param string $column
     * @return mixed
     */
    public function avg($column = '*')
    {
        $this->fn("AVG", $column);
        return new AsFieldClause($this);
    }


    /**
     * Retrieve the maximum value of a given column.
     *
     * @param string $column
     * @return mixed
     */
    public function max($column)
    {
        $this->fn("MAX", $column);
        return new AsFieldClause($this);
    }

    /**
     * Retrieve the minimum value of a given column.
     *
     * @param string $column
     * @return mixed
     */
    public function min($column)
    {
        $this->fn("MIN", $column);
        return new AsFieldClause($this);
    }

    public function raw($column, $operator, $value = null)
    {
        $this->fix_operator_and_value($operator, $value);
        $this->fix_column_name($column);
        $this->stringArray[] = "$column $operator $value";
        return new AsFieldClause($this);
    }

    public function fn($type, $column)
    {
        if ($column != '*') {
            $column = $this->fix_column_name($column)['name'];
        }

        $this->stringArray[] = "$type($column)";
    }

    public function getString()
    {
        return implode(',', $this->stringArray);
    }
}