<?php

namespace Sophy\Database\Drivers\Mysql;

trait ProcessClause {
    private $param_index = 0;

    public function getSourceValueItem($struct_name) {
        $s_index = $this->sql_stractur($struct_name);
        return $this->sourceValue[$s_index] ?? [];
    }

    protected function addToSourceArray($struct_name, $value) {
        $s_index = $this->sql_stractur($struct_name);
        $this->sourceValue[$s_index][] = $value;
    }

    protected function clearSource($struct_name) {
        $s_index = $this->sql_stractur($struct_name);
        $this->sourceValue[$s_index] = [];
    }
    protected function clearSourceValue() {
        $this->sourceValue = [];
    }

    protected function method_in_maker(array $list, $callback) {
        foreach ($list as $item) {
            $param_name = $this->add_to_param_auto_name($item);
            $callback($param_name);
        }
    }

    private function queryMakerJoin($type, $args) {
        $join_table = $args[0];
        $join_table_column = $args[1];
        $operator = $args[2] ?? false;
        $main_column = $args[3] ?? false;

        if (!$operator && !$main_column) {
            $table_second = $this->fix_column_name($join_table);
            $table_main = $this->fix_column_name($join_table_column);

            $join_table = $table_second['table'];

            $join_table_column = $table_second['name'];

            $operator = '=';

            $main_column = $table_main['name'];
        } elseif ($operator && !$main_column) {
            $table_second = $this->fix_column_name($join_table);
            $table_main = $this->fix_column_name($operator);

            $operator = $join_table_column;

            $join_table = $table_second['table'];
            $join_table_column = $table_second['name'];

            $main_column = $table_main['name'];
        } elseif ($main_column) {
            $join_table = "`$join_table`";

            $join_table_column = $this->fix_column_name($join_table_column)['name'];
            $main_column = $this->fix_column_name($main_column)['name'];
        }

        return "$type JOIN $join_table ON $join_table_column $operator $main_column";
    }

    protected function add_to_param($name, $value) {
        if ($value === false) {
            $value = 0;
        } elseif ($value === true) {
            $value = 1;
        }

        $this->params[":$name"] = $value;
        return ":$name";
    }

    protected function add_to_param_auto_name($value) {
        $name = $this->get_new_param_name();
        return $this->add_to_param($name, $value);
    }

    protected function get_new_param_name() {
        $this->param_index++;
        return 'p' . $this->param_index;
    }

    protected function fix_column_name($name) {
        $array = explode('.', $name);
        $count = count($array);

        $table = '';
        $column = '';
        $type = '';

        if ($count == 1) {
            $table = $this->table;
            $column = $array[0];
            $type = 'column';
        } elseif ($count == 2) {
            $table = $array[0];
            $column = $array[1];
            $type = 'table_and_column';
        }

        if ($column != '*') {
            $column = "`$column`";
        }

        $table = "`$table`";

        return ['name' => "$table.$column", 'table' => $table, 'column' => $column, 'type' => $type];
    }

    protected function fix_operator_and_value(&$operator, &$value) {
        if ($value == false || $value == null) {
            $value = $operator;
            $operator = '=';
        }
    }

    protected function raw_maker($query, $values) {
        $index = 0;

        do {
            $find = strpos($query, '?');

            if ($find === false) {
                break;
            }

            $param_name = $this->add_to_param_auto_name($values[$index]);
            $query = substr_replace($query, $param_name, $find, 1);
            $index++;
        } while ($find !== false);

        return $query;
    }

    public function get_value($param, $name) {
        return $param->{$name};
    }

    public function get_params() {
        return $this->params;
    }

    public function get_sourceValue() {
        return $this->sourceValue;
    }

    protected function makeInsertQueryString($values) {
        $param_name = [];
        $param_value_name_list = [];

        foreach ($values as $name => $value) {
            $param_name[] = $this->fix_column_name($name)['name'];
            $param_value_name_list[] = $this->add_to_param_auto_name($value);
        }

        return "INSERT INTO `$this->table` (" . implode(',', $param_name) . ") VALUES (" . implode(',', $param_value_name_list) . ")";
    }

    protected function makeUpdateQueryString($values) {
        $params = [];
        foreach ($values as $name => $value) {
            $params[] = $this->fix_column_name($name)['name'] . ' = ' . $this->add_to_param_auto_name($value);
        }

        $extra = $this->makeSourceValueString();

        return "UPDATE `$this->table` SET " . implode(',', $params) . " $extra";
    }

    protected function makeUpdateQueryIncrement(string $column, $value = 1, $action = '+') {
        $values = [];

        $column = $this->fix_column_name($column)['name'];

        $params = [];
        $params[] = "$column = $column $action $value";

        foreach ($values as $name => $value) {
            $params[] = $this->fix_column_name($name)['name'] . ' = ' . $this->add_to_param_auto_name($value);
        }

        $extra = $this->makeSourceValueString();

        return "UPDATE `$this->table` SET " . implode(',', $params) . " $extra";
    }

    protected function makeDeleteQueryString() {
        $extra = $this->makeSourceValueString();
        return "DELETE FROM `$this->table` $extra";
    }

    protected function sql_stractur($key = null) {
        $arr = [
            'SELECT' => 1,
            'FIELDS' => 2,
            'ALL' => 3,
            'DISTINCT' => 4,
            'SQL_CALC_FOUND_ROWS' => 5,
            'DISTINCTROW' => 6,
            'HIGH_PRIORITY' => 7,
            'STRAIGHT_JOIN' => 8,
            'FROM' => 9,
            'JOIN' => 10,
            'WHERE' => 11,
            'GROUP_BY' => 12,
            'HAVING' => 13,
            'ORDER_BY' => 14,
            'LIMIT' => 15,
            'OFFSET' => 16,
            'UNION' => 17
        ];
        if ($key == null) {
            return $arr;
        } else {
            return $arr[$key];
        }
    }
}
