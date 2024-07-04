<?php

namespace Sophy\Domain;

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
use Sophy\Domain\IEntityBase;
use Sophy\Exceptions\ConexionDBException;

abstract class EntityBase implements IEntityBase {
    use SelectClause;
    use WhereClause;
    use GroupByClause;
    use OrderByClause;
    use PaginateClause;

    use FunctionsClause;

    use InsertClause;

    use UpdateClause;

    use DeleteClause;

    private static ?IDBDriver $driver = null;

    private $config;
    private $params = [];
    private $action = 'select';
    private $callFoundRows = false;
    private $sourceValue = [];

    protected $primaryKey = 'id';

    protected array $fillable = [];
    protected array $attributes = [];

    private $table;
    private $nameSpaceModel = 'App\\Model\\%s';

    public function __construct() {
        if (is_null($this->table)) {
            $subclass = new \ReflectionClass(static::class);
            $this->table = snake_case("{$subclass->getShortName()}");
        }
    }

    public static function create(array $attributes) {
        return (new static())->massAsign($attributes);
    }

    public static function update(array $attributes, int $id) {
        return (new static())->massAsign($attributes, $id);
    }

    public static function table() {
        return new static();
    }

    protected function massAsign(array $attributes, $id = null) {
        if (count($this->fillable) == 0) {
            throw new \Error("Entidad " . static::class . " no tiene atributos por asignar");
        }

        if (isset($id)) {
            $this->attributes[$this->primaryKey] = $id;
        }

        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }

        return $this;
    }

    public static function setDatabaseDriver(IDBDriver $driver) {
        self::$driver = $driver;
    }

    /**
     * @param string $table
     * @return void
     */
    public function setTable(string $table) {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

    public function getAction() {
        return $this->action;
    }

    public function callFoundRows() {
        return $this->callFoundRows = true;
    }

    public function save() {
        try {
            if (isset($this->attributes[$this->primaryKey])) {
                $id = $this->attributes[$this->primaryKey];
                $this->where($this->primaryKey, $id)->update($this->attributes, $id);
            } else {
                $id = $this->insertGetId($this->attributes);
                $this->attributes[$this->primaryKey] = $id;
            }
            return $this->attributes;
        } catch (\Exception $exception) {
            throw ConexionDBException::showMessage($exception->getMessage());
        }
    }

    public function delete() {
        try {
            return $this->deleteRow();
        } catch (\Exception $exception) {
            throw ConexionDBException::showMessage($exception->getMessage());
        }
    }

    public function first($columns = []) {
        $db = $this->limit(1);

        if (count($columns)) {
            $db->select($columns);
        }

        return $db->getOne();
    }

    /**
     * Determine if any rows exist for the current query.
     *
     * @return bool
     */
    public function exists() {
        $result = $this->first();
        return $result ? true : false;
    }

    /**
     * Determine if no rows exist for the current query.
     *
     * @return bool
     */
    public function doesntExist() {
        return !$this->exists();
    }

    protected function execute($query, $params = [], $return = false, $isList = true) {
        $this->params = $params;

        if ($this->params == null) {
            $stmt = self::$driver->query($query);
        } else {
            $stmt = self::$driver->statement($query, $this->params);
        }

        if ($return) {
            $table = ucfirst($this->getTable());

            if ($isList == true) {
                $stmt->setFetchMode(self::$driver->getConnection()::FETCH_CLASS, sprintf($this->nameSpaceModel, $table));
                $result = $stmt->fetchAll();
            } else {
                $result = $stmt->fetchObject(sprintf($this->nameSpaceModel, $table));
            }
        } else {
            $result = $stmt->rowCount();
        }

        return $result;
    }

    public function get() {
        $query = $this->makeSelectQueryString();
        return $this->execute($query, $this->params, true);
    }

    public function getOne() {
        $query = $this->makeSelectQueryString();
        return $this->execute($query, $this->params, true, false);
    }
}
