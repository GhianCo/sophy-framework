<?php

namespace Sophy\Database\Drivers\Mysql;

trait OrderByClause
{

    use ProcessClause;

    /**
     * Add an "order by" clause to the query.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $column = $this->fix_column_name($column)['name'];
        $this->addToSourceArray('ORDER_BY', "ORDER BY $column $direction");
        return $this;
    }


    /**
     * Add an "order by count(`column`)" clause to the query.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderByCount($column, $direction = 'asc')
    {
        $column = $this->fix_column_name($column)['name'];
        $this->addToSourceArray('ORDER_BY', "ORDER BY COUNT($column) $direction");
        return $this;
    }


    public function inRandomOrder()
    {
        $this->addToSourceArray('ORDER_BY', "ORDER BY RAND()");
        return $this;
    }


    public function latest($column = 'created_at')
    {
        $this->orderBy($column, 'DESC');
        return $this;
    }

    public function oldest($column = 'created_at')
    {
        $this->orderBy($column, 'ASC');
        return $this;
    }

}