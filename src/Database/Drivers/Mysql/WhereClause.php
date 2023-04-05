<?php

namespace Sophy\Database\Drivers\Mysql;

trait WhereClause
{
    use ProcessClause;

    protected function addOperator($oprator)
    {
        $array = $this->getSourceValueItem('WHERE');

        if (count($array) > 0) {

            $end = $array[count($array) - 1];

            if (in_array($end, ['AND', 'OR', '(']) == false) {
                $this->addToSourceArray('WHERE', $oprator);
            }
        } else {
            $this->addToSourceArray('WHERE', 'WHERE');
        }
    }

    private function queryMakerWhere($args, $extra_operation = '')
    {

        if (is_string($args[0])) {

            $column = $args[0];
            $operator = $args[1];
            $value = $args[2] ?? false;


            $this->fix_operator_and_value($operator, $value);

            $column = $this->fix_column_name($column)['name'];

            $value_name = $this->add_to_param_auto_name($value);


            $query = "$column $operator $value_name";

            /*
            | Add NOT to query
            */
            if (!empty($extra_operation)) {
                $query = 'NOT ' . $query;
            }

            /*
            | Add finally string to Source
            */
            $this->addToSourceArray('WHERE', $query);
        } else if (is_callable($args[0])) {

            $this->addStartParentheses();
            $args[0]($this);
            $this->addEndParentheses();
        }
    }

    private function queryMakerWhereStaticValue($name, $value)
    {
        $name = $this->fix_column_name($name)['name'];

        $query = "$name $value";

        if (!empty($extra_operation)) {
            $query = 'NOT ' . $query;
        }

        $this->addToSourceArray('WHERE', $query);
    }

    private function queryMakerWhereBetween($name, array $values, $extra_operation = '')
    {
        $name = $this->fix_column_name($name)['name'];

        $v1 = $this->add_to_param_auto_name($values[0]);
        $v2 = $this->add_to_param_auto_name($values[1]);

        $query = "$name BETWEEN $v1 AND $v2";

        if (!empty($extra_operation)) {
            $query = 'NOT ' . $query;
        }

        $this->addToSourceArray('WHERE', $query);
    }

    private function queryMakerWhereLikeDate($action, $args)
    {

        $column = $args[0];
        $operator = $args[1];
        $value = $args[2] ?? false;

        $this->fix_operator_and_value($operator, $value);

        $column = $this->fix_column_name($column)['name'];

        $value_name = $this->add_to_param_auto_name($column);


        $query = "$action($column) $operator $value_name";

        $this->addToSourceArray('WHERE', $query);
    }

    public function find($id, $columns = [])
    {
        return $this->where($this->primaryKey, $id)->first($columns);
    }

    public function where(...$args)
    {
        $this->addOperator('AND');
        $this->queryMakerWhere($args);
        return $this;
    }

    public function orWhere(...$args)
    {
        $this->addOperator('OR');
        $this->queryMakerWhere($args);
        return $this;
    }

    public function whereNot(...$args)
    {
        $this->addOperator('AND');
        $this->queryMakerWhere($args, 'NOT');
        return $this;
    }

    public function orWhereNot(...$args)
    {
        $this->addOperator('OR');
        $this->queryMakerWhere($args, 'NOT');
        return $this;
    }

    public function whereNull($name)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereStaticValue($name, 'IS NULL');
        return $this;
    }

    public function orWhereNull($name)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereStaticValue($name, 'IS NULL');
        return $this;
    }

    public function whereNotNull($name)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereStaticValue($name, 'IS NOT NULL');
        return $this;
    }

    public function orWhereNotNull($name)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereStaticValue($name, 'IS NOT NULL');
        return $this;
    }


    public function whereBetween($name, array $values)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereBetween($name, $values);
        return $this;
    }

    public function orWhereBetween($name, array $values)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereBetween($name, $values);
        return $this;
    }

    public function whereNotBetween($name, array $values)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereBetween($name, $values, 'NOT');
        return $this;
    }

    public function orWhereNotBetween($name, array $values)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereBetween($name, $values, 'NOT');
        return $this;
    }


    public function whereRaw($query, array $values, $boolean = 'AND')
    {
        $this->addOperator($boolean);
        $this->addToSourceArray('WHERE', $this->raw_maker($query, $values));
        return $this;
    }

    public function orWhereRaw($query, array $values)
    {
        return $this->whereRaw($query, $values, 'OR');
    }


    public function whereDate(...$args)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereLikeDate('DATE', $args);
        return $this;
    }

    public function orWhereDate(...$args)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereLikeDate('DATE', $args);
        return $this;
    }

    public function whereYear(...$args)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereLikeDate('YEAR', $args);
        return $this;
    }

    public function orWhereYear(...$args)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereLikeDate('YEAR', $args);
        return $this;
    }

    public function whereMonth(...$args)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereLikeDate('MONTH', $args);
        return $this;
    }

    public function orWhereMonth(...$args)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereLikeDate('MONTH', $args);
        return $this;
    }


    public function whereDay(...$args)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereLikeDate('DAY', $args);
        return $this;
    }

    public function orWhereDay(...$args)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereLikeDate('DAY', $args);
        return $this;
    }

    public function whereTime(...$args)
    {
        $this->addOperator('AND');
        $this->queryMakerWhereLikeDate('TIME', $args);
        return $this;
    }

    public function orWhereTime(...$args)
    {
        $this->addOperator('OR');
        $this->queryMakerWhereLikeDate('TIME', $args);
        return $this;
    }

    public function and(...$args)
    {
        return $this->where(...$args);
    }

    public function or(...$args)
    {
        return $this->orWhere(...$args);
    }


    public function not(...$args)
    {
        return $this->whereNot(...$args);
    }

    public function orNot(...$args)
    {
        return $this->orWhereNot(...$args);
    }

    public function like($column, $value)
    {
        return $this->where($column, 'like', $value);
    }

    public function orLike($column, $value)
    {
        return $this->orWhere($column, 'like', $value);
    }


    public function null($column)
    {
        return $this->whereNull($column);
    }

    public function orNull($column)
    {
        return $this->orWhereNull($column);
    }


    public function notNull($column)
    {
        return $this->whereNotNull($column);
    }

    public function orNotNull($column)
    {
        return $this->orWhereNotNull($column);
    }


    public function is($column, $boolean = true)
    {
        return $this->where($column, $boolean);
    }

    public function true($column)
    {
        return $this->is($column, false);
    }

    public function false($column)
    {
        return $this->is($column, false);
    }

    public function date(...$args)
    {
        return $this->whereDate(...$args);
    }

    public function orDate(...$args)
    {
        return $this->orWhereDate(...$args);
    }


    public function year(...$args)
    {
        return $this->whereYear(...$args);
    }

    public function orYear(...$args)
    {
        return $this->orWhereYear(...$args);
    }


    public function month(...$args)
    {
        return $this->whereMonth(...$args);
    }

    public function orMonth(...$args)
    {
        return $this->orWhereMonth(...$args);
    }


    public function day(...$args)
    {
        return $this->whereDay(...$args);
    }

    public function orDay(...$args)
    {
        return $this->orWhereDay(...$args);
    }


    public function time(...$args)
    {
        return $this->whereTime(...$args);
    }

    public function orTime(...$args)
    {
        return $this->orWhereTime(...$args);
    }

    private function queryMakerIn($name, array $list, $extra_opration = '')
    {
        $name = $this->fix_column_name($name)['name'];

        $values = [];

        $this->method_in_maker($list, function ($get_param_name) use (&$values) {
            $values[] = $get_param_name;
        });

        $string_query_name = $name;

        if (!empty($extra_opration)) {
            $string_query_name .= ' ' . $extra_opration;
        }

        $string_query_value = 'IN(' . implode(',', $values) . ')';

        $string_query = "$string_query_name $string_query_value";

        return $string_query;
    }

    public function whereIn($name, array $list)
    {
        $query = $this->queryMakerIn($name, $list, '');
        $this->addOperator('AND');
        $this->addToSourceArray('WHERE', $query);
        return $this;
    }

    public function in($name, array $list)
    {
        return $this->whereIn($name, $list);
    }

    public function whereNotIn($name, array $list)
    {
        $query = $this->queryMakerIn($name, $list, 'NOT');
        $this->addOperator('AND');
        $this->addToSourceArray('WHERE', $query);
        return $this;
    }

    public function notIn($name, array $list)
    {
        return $this->whereNotIn($name, $list);
    }

    public function orWhereIn($name, array $list)
    {
        $query = $this->queryMakerIn($name, $list, '');
        $this->addOperator('OR');
        $this->addToSourceArray('WHERE', $query);
        return $this;
    }

    public function orIn($name, array $list)
    {
        return $this->orWhereIn($name, $list);
    }

    public function orWhereNotIn($name, array $list)
    {
        $query = $this->queryMakerIn($name, $list, 'NOT');
        $this->addOperator('OR');
        $this->addToSourceArray('WHERE', $query);
        return $this;
    }

    public function orNotIn($name, array $list)
    {
        return $this->orwhereNotIn($name, $list);
    }

    protected function addStartParentheses()
    {
        $this->addToSourceArray('WHERE', '(');
    }

    protected function addEndParentheses()
    {
        $this->addToSourceArray('WHERE', ')');
    }

}