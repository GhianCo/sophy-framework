<?php

namespace Sophy\Infrastructure;

use Sophy\Database\Drivers\IDBDriver;
use Sophy\Database\Drivers\Mysql\DeleteClause;
use Sophy\Database\Drivers\Mysql\FunctionsClause;
use Sophy\Database\Drivers\Mysql\GroupByClause;
use Sophy\Database\Drivers\Mysql\InsertClause;
use Sophy\Database\Drivers\Mysql\OrderByClause;
use Sophy\Database\Drivers\Mysql\PaginateClause;
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
    use PaginateClause;

    use FunctionsClause;

    use InsertClause;

    use UpdateClause;

    use DeleteClause;

    public IDBDriver $driver;

    protected $config;
    protected $params = [];
    protected $action = 'select';
    protected $callFoundRows = false;
    protected $sourceValue = [];

    protected $primaryKey = 'id';

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
        $this->primaryKey = $this->table . '_id';
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
                $this->where($this->primary_key, $entity->{$this->primary_key})->update($entity);
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
            return $this->deleteRow($entity);
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
