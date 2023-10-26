<?php

namespace Sophy\Database\Drivers\Mysql;

trait FunctionsClause {
    use SelectClause;

    /**
     * Retrieve the "count" result of the query.
     *
     * @param  string  $columns
     * @return int
     */

    public function count($column = '*') {
        $this->select(function ($query) use ($column) {
            $query->count($column)->as('count');
        });
        return $this->get_value($this->first(), 'count');
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param  string  $columns
     * @return int
     */
    public function sum($column = '*') {
        $this->select(function ($query) use ($column) {
            $query->sum($column)->as('sum');
        });

        return $this->get_value($this->first(), 'sum');
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function avg($column = '*') {
        $this->select(function ($query) use ($column) {
            $query->avg($column)->as('avg');
        });

        return $this->get_value($this->first(), 'avg');
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function min($column = '*') {
        $this->select(function ($query) use ($column) {
            $query->min($column)->as('min');
        });

        return $this->get_value($this->first(), 'min');
    }

    /**
     * Retrieve the average of the values of a given column.
     *
     * @param  string  $column
     * @return mixed
     */
    public function max($column = '*') {
        $this->select(function ($query) use ($column) {
            $query->max($column)->as('max');
        });

        return $this->get_value($this->first(), 'max');
    }

    /**
     * Get a single column's value from the first result of a query.
     *
     * @param  string  $column
     * @return mixed
     */
    public function value($column = '*') {
        return $this->get_value($this->first(), $column);
    }
}
