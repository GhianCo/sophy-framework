<?php

namespace Sophy\Database\Drivers\Mysql;

use PDO;

trait LimitOffsetClause
{

    use ProcessClause;

    /**
     * Set the "limit" value of the query.
     *
     * @param int $value
     * @return $this
     */
    public function limit(int $value)
    {
        $this->addToSourceArray('LIMIT', "LIMIT $value");
        return $this;
    }

    /**
     * Alias to set the "limit" value of the query.
     *
     * @param int $value
     * @return mixed
     */
    public function take(int $value)
    {
        return $this->limit($value);
    }


    /**
     * Set the "offset" value of the query.
     *
     * @param int $value
     * @return $this
     */
    public function offset(int $offset)
    {
        $this->addToSourceArray('OFFSET', "OFFSET $offset");
        return $this;
    }

    /**
     * Alias to set the "offset" value of the query.
     *
     * @param int $value
     * @return mixed
     */

    public function skip(int $skip)
    {
        return $this->offset($skip);
    }

    public function page(int $value, int $take)
    {
        $offset = $value * $take;
        return $this->take($take)->offset($offset)->get();
    }

    public function paginate(int $value, int $take = 15)
    {
        $this->callFoundRows();
        $data = $this->page($value - 1, $take);

        $result = $this->driver->query("SELECT FOUND_ROWS() AS foundRows");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $total = $result->fetch()["foundRows"];

        $startIndex = (($value - 1) * $take) + 1;
        $endIndex = min(($take * $value), $total);
        $totalPages = ceil($total / ($take > 0 ? $take : 1));

        return [
            'data' => $data,
            'pagination' => [
                'totalRows' => $total,
                'totalPages' => $totalPages,
                'currentPage' => $value,
                'perPage' => $take,
                'startIndex' => $startIndex,
                'endIndex' => $endIndex,
                'hasRowsToLeft' => $startIndex === 1,
                'hasRowsToRight' => $endIndex === $total
            ]
        ];
    }

}