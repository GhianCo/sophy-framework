<?php

namespace Sophy\Database\Drivers\Mysql;

trait UpdateClause
{

    use ProcessClause;

    public function update($values)
    {
        $this->setAction('update');
        $this->clearSource('DISTINCT');
        $query = $this->makeUpdateQueryString($values);
        return $this->execute($query, $this->params);
    }

    public function increment(string $column, int $value = 1)
    {
        $query = $this->makeUpdateQueryIncrement($column, $value);
        return $this->execute($query, $this->params);
    }


    public function decrement(string $column, int $value = 1)
    {
        $query = $this->makeUpdateQueryIncrement($column, $value, '-');
        return $this->execute($query, $this->params);
    }


}