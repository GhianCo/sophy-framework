<?php

namespace Sophy\Database\Drivers\Mysql;

class JoinClause
{
    use ProcessClause;

    public function join(...$args)
    {
        $query = $this->queryMakerJoin('INNER', $args);
        $this->addToSourceArray('JOIN', $query);
        return $this;
    }

    public function leftJoin(...$args)
    {
        $query = $this->queryMakerJoin('LEFT', $args);
        $this->addToSourceArray('JOIN', $query);
        return $this;
    }

    public function rightJoin(...$args)
    {
        $query = $this->queryMakerJoin('RIGHT', $args);
        $this->addToSourceArray('JOIN', $query);
        return $this;
    }

    public function fullJoin(...$args)
    {
        $query = $this->queryMakerJoin('FULL', $args);
        $this->addToSourceArray('JOIN', $query);
        return $this;
    }

    public function crossJoin($column)
    {
        $this->addToSourceArray('JOIN', "CROSS JOIN `$column`");
        return $this;
    }
}