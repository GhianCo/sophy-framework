<?php

namespace Sophy\Database\Drivers\Mysql;

trait SelectClause
{
    use ProcessClause;

    public function select(...$args)
    {
        $this->clearSource('DISTINCT');

        if (count($args) == 1 && !is_string($args[0]) && !$args[0] instanceof RawClause) {
            if (is_array($args[0])) {
                foreach ($args[0] as $key => $arg) {
                    $args[$key] = $this->fix_column_name($arg)['name'];
                }

                $this->addToSourceArray('DISTINCT', implode(',', $args));
            } elseif (is_callable($args[0])) {
                $select = new SelectFunctionsClause();
                $select->setTable($this->table);
                $args[0]($select);
                $this->addToSourceArray('DISTINCT', $select->getString());
            }
        } else {
            foreach ($args as $key => $arg) {
                if ($arg instanceof RawClause) {
                    $args[$key] = $this->raw_maker($arg->getRawQuery(), $arg->getRawValues());
                } else {
                    $args[$key] = $this->fix_column_name($arg)['name'];
                }
            }

            $this->addToSourceArray('DISTINCT', implode(',', $args));
        }


        return $this;
    }

    protected function makeSelectQueryString()
    {

        $this->addToSourceArray('SELECT', "SELECT" . ($this->callFoundRows ? ' SQL_CALC_FOUND_ROWS' : ''));
        $this->addToSourceArray('FROM', "FROM `$this->table`");

        if (count($this->getSourceValueItem('DISTINCT')) == 0) {
            $this->select('*');
        }

        return $this->makeSourceValueString();
    }

    protected function makeSourceValueString(){
        ksort($this->sourceValue);

        $array = [];
        foreach ($this->sourceValue as $value) {
            if (is_array($value) && count($value)) {
                $array[] = implode(' ', $value);
            }
        }

        return implode(' ', $array);
    }

    public function selectRaw($query, $values = [])
    {
        $raw = new RawClause();
        $raw->setRawData($query, $values);
        $this->select($raw);
        return $this;
    }
}