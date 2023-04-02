<?php

namespace Sophy\Infrastructure;

use Sophy\Database\Drivers\IDBDriver;
use Sophy\Database\Drivers\Mysql\GroupByClause;
use Sophy\Database\Drivers\Mysql\InsertClause;
use Sophy\Database\Drivers\Mysql\LimitOffsetClause;
use Sophy\Database\Drivers\Mysql\OrderByClause;
use Sophy\Database\Drivers\Mysql\SelectClause;
use Sophy\Database\Drivers\Mysql\UpdateClause;
use Sophy\Database\Drivers\Mysql\WhereClause;
use Sophy\Domain\BaseEntity;
use Sophy\Domain\BaseRepository;
use Sophy\Domain\Exceptions\ConexionDBException;
use PDO;

abstract class BaseRepositoryMysql implements BaseRepository
{
    use SelectClause;
    use WhereClause;
    use GroupByClause;
    use OrderByClause;
    use LimitOffsetClause;

    use InsertClause;

    use UpdateClause;

    public IDBDriver $driver;

    protected $config;
    protected $params = [];
    protected $action = 'select';
    protected $callFoundRows = false;
    protected $source_value = [];

    protected $primary_key = 'id';

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
        $this->primary_key = $this->table . '_id';
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function callFoundRows()
    {
        return $this->callFoundRows = true;
    }

    public function save(BaseEntity $entity): BaseEntity
    {
        try {
            if (isset($entity->{$this->primary_key})) {
                $this->setAction('update')->where($this->primary_key, $entity->{$this->primary_key})->update($entity);
            } else {
                $id = $this->insertGetId($entity);
                $entity->{$this->primary_key} = $id;
            }
            return $entity;
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

    public function first($columns = [])
    {
        $db = $this->limit(1);

        if (count($columns)) {
            $db->select($columns);
        }

        return $db->getOne();
    }

    public function find($id, $columns = [])
    {
        return $this->where($this->primary_key, $id)->first($columns);
    }

    /**
     * Determine if any rows exist for the current query.
     *
     * @return bool
     */
    public function exists()
    {
        $result = $this->first();
        return $result ? true : false;
    }

    /**
     * Determine if no rows exist for the current query.
     *
     * @return bool
     */
    public function doesntExist()
    {
        return !$this->exists();
    }

    protected function execute($query, $params = [], $return = false, $isList = true)
    {
        $this->params = $params;

        if ($this->params == null) {
            $stmt = $this->driver->query($query);
        } else {
            $stmt = $this->driver->statement($query, $this->params);
        }

        if ($return) {

            $table = ucfirst($this->getTable());

            if ($isList == true) {
                $stmt->setFetchMode(PDO::FETCH_CLASS, sprintf($this->nameSpaceEntity, $table, $table));
                $result = $stmt->fetchAll();
            } else {
                $result = $stmt->fetchObject(sprintf($this->nameSpaceEntity, $table, $table));
            }

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

    public function getOne()
    {
        $query = $this->makeSelectQueryString();
        return $this->execute($query, $this->params, true, false);
    }

}
