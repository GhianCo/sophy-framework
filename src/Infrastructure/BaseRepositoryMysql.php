<?php

namespace Sophy\Infrastructure;

use Sophy\Constants;
use Sophy\Database\Drivers\IDBDriver;
use Sophy\Database\Drivers\Mysql\LimitOffsetClause;
use Sophy\Database\Drivers\Mysql\SelectClause;
use Sophy\Database\Drivers\Mysql\WhereClause;
use Sophy\Domain\BaseEntity;
use Sophy\Domain\BaseRepository;
use Sophy\Domain\Exceptions\ConexionDBException;
use PDO;

abstract class BaseRepositoryMysql implements BaseRepository
{
    use SelectClause;
    use WhereClause;
    use LimitOffsetClause;

    public IDBDriver $driver;

    protected $config;
    protected $params = [];
    protected $source_value = [];

    private $table;
    private $nameSpaceEntity = 'App\\%s\\Domain\\Entities\\%s';

    public function __construct(IDBDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param string $table
     * @return void
     */
    public function setTable(string $table)
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    public function insert(BaseEntity $entity): int
    {
        try {
            $insertQuery = $this->insertQuery($this->getTable());

            foreach ($entity as $key => $value) {
                if (!isset($value)) {
                    continue;
                }
                $insertQuery->columns($key);
            }

            $binds = [];
            foreach ($entity as $key => &$value) {
                if (!isset($value)) {
                    continue;
                }
                $binds[':' . $key] = $value;
            }

            $statement = $this->driver->statement($insertQuery, $binds);

            if ($statement->rowCount() === 1) {
                return $this->driver->lastInsertId();
            } else {
                return Constants::NOT;
            }
        } catch (\Exception $exception) {
            throw new ConexionDBException($exception->getMessage(), 500);
        }
    }

    public function update(BaseEntity $entity): void
    {
        try {
            $updateQuery = $this->updateQuery($this->getTable());

            foreach ($entity as $key => $value) {
                if ($key == $this->getKeyName()) {
                    continue;
                }
                $updateQuery->set($key);
            }

            $updateQuery->where($this->getKeyName() . ' = :' . $this->getKeyName());

            $binds = [];
            foreach ($entity as $key => &$value) {
                $binds[':' . $key] = $value;
            }

            $this->driver->statement($updateQuery, $binds);
        } catch (\Exception $exception) {
            throw new ConexionDBException($exception->getMessage(), 500);
        }
    }

    public function delete(BaseEntity $entity)
    {
        try {
            $statement = $this->driver->statement(
                'DELETE FROM ' . $this->getTable() . ' WHERE ' . $this->getKeyName() . '=:' . $this->getKeyName() . ' LIMIT 1',
                [':' . $this->getKeyName() => $entity->{$this->getKeyName()}]
            );
            return $statement->rowCount();
        } catch (\Exception $exception) {
            throw new ConexionDBException($exception->getMessage(), 500);
        }
    }

    protected function execute($query, $params = [], $return = false)
    {
        $this->params = $params;

        if ($this->params == null) {
            $stmt = $this->driver->query($query);
        } else {
            $stmt = $this->driver->statement($query, $this->params);
        }

        $table = ucfirst($this->getTable());
        $stmt->setFetchMode(PDO::FETCH_CLASS, sprintf($this->nameSpaceEntity, $table, $table));

        if ($return) {
            $result = $stmt->fetchAll();
        } else {
            $result = $stmt->rowCount();
        }

        return $result;
    }

    public function get()
    {
        $query = $this->makeSelectQueryString();
        return $this->execute($query, $this->params, true);
    }

    protected function execQueryRows()
    {
        try {
            $selectQuery = $this->selectQuery($this->getTable(), is_array($this->getColumns()) && count($this->getColumns()) ? implode(', ', $this->getColumns()) : '*')
                ->callFoundRows(true)
                ->where($this->buildWhere());

            foreach ($this->getJoins() as $join) {
                if (isset($join['interception'])) {
                    $interception = $join['interception'] . 'Join';
                    $selectQuery->{$interception}($join['table'] . ' ON ' . $join['table'] . '.' . $join['tablePK'] . ' = ' . $this->getTable() . '.' . $join['tablePK']);
                } else {
                    $selectQuery->innerJoin($join['table'] . ' ON ' . $join['table'] . '.' . $join['tablePK'] . ' = ' . $this->getTable() . '.' . $join['tablePK']);
                }
            }

            foreach ($this->getOrderParams() as $op) {
                $selectQuery->orderBy($op['field'] . ' ' . (isset($op['order']) ? $op['order'] : ''));
            }

            if ($this->getPerPage() != 0 && $this->getPerPage() != Constants::UNDEFINED) {
                $selectQuery->page(($this->getPage() - 1) * $this->getPerPage());
                $selectQuery->perPage($this->getPerPage());
            }

            $binds = [];
            foreach ($this->getWhereParams() as $wp) {
                if (!isset($wp['value']) || is_array($wp['value'])) {
                    continue;
                }
                $fieldClean = str_replace('.', '', $wp['field']);
                $binds[':' . (is_array($wp["field"]) ? implode('', $wp["field"]) : $fieldClean)] = $wp["value"];
            }

            $statement = $this->driver->statement($selectQuery, $binds);

            $table = ucfirst($this->getTable());
            $statement->setFetchMode(PDO::FETCH_CLASS, sprintf($this->nameSpaceEntity, $table, $table));

            $result = $this->driver->query("SELECT FOUND_ROWS() AS foundRows");
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $total = $result->fetch()["foundRows"];

            $startIndex = (($this->getPage() - 1) * $this->getPerPage()) + 1;
            $endIndex = min(($this->getPerPage() * $this->getPage()), $total);
            $totalPages = ceil($total / ($this->getPerPage() > 0 ? $this->getPerPage() : 1));

            return [
                'data' => $statement->fetchAll(),
                'pagination' => [
                    'totalRows' => $total,
                    'totalPages' => $totalPages,
                    'currentPage' => $this->getPage(),
                    'perPage' => $this->getPerPage(),
                    'startIndex' => $startIndex,
                    'endIndex' => $endIndex,
                    'hasRowsToLeft' => $startIndex === 1,
                    'hasRowsToRight' => $endIndex === $total
                ]
            ];
        } catch (\Exception $exception) {
            throw new ConexionDBException($exception->getMessage(), 500);
        }
    }

    protected function execQueryRow()
    {
        try {
            $selectQuery = $this->selectQuery($this->getTable(), is_array($this->getColumns()) && count($this->getColumns()) ? implode(', ', $this->getColumns()) : '*')
                ->where($this->buildWhere())
                ->page(1);

            foreach ($this->getJoins() as $join) {
                $selectQuery->innerJoin($join['table'] . ' ON ' . $join['table'] . '.' . $join['tablePK'] . ' = ' . $this->getTable() . '.' . $join['tablePK']);
            }

            $binds = [];
            foreach ($this->getWhereParams() as $wp) {
                $fieldClean = str_replace('.', '', $wp['field']);
                $binds[':' . (is_array($wp["field"]) ? implode('', $wp["field"]) : $fieldClean)] = $wp["value"];
            }

            $statement = $this->driver->statement($selectQuery, $binds);
            $table = ucfirst($this->getTable());

            return $statement->fetchObject(sprintf($this->nameSpaceEntity, $table, $table));
        } catch (\Exception $exception) {
            throw new ConexionDBException($exception->getMessage(), 500);
        }
    }
}
