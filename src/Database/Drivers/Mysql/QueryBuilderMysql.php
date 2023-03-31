<?php

namespace Sophy\Database\Drivers\Mysql;

use Sophy\Database\Drivers\Interfaces\IInsertQueryBuilder;
use Sophy\Database\Drivers\Interfaces\IUpdateQueryBuilder;
use Sophy\Database\Drivers\Interfaces\ISelectQueryBuilder;

trait QueryBuilderMysql {
    protected static function selectQuery(string $table, string ...$fields): ISelectQueryBuilder {
        return new SelectQueryBuilder($table, $fields);
    }

    protected static function insertQuery(string $table): IInsertQueryBuilder {
        return new InsertQueryBuilder($table);
    }

    protected static function updateQuery($table): IUpdateQueryBuilder {
        return new UpdateQueryBuilder($table);
    }

    protected function buildWhere() {
        $conditions = [];

        foreach ($this->whereParams as $index => $wp) {
            $statementWhere = '';
            $operatorConditional = 'where';
            $conditional = '';
            $operator = isset($wp['operator']) ? $wp['operator'] : '=';
            $fieldClean = str_replace('.', '', $wp['field']);

            if (isset($wp['conditional'])) {
                if ($wp['conditional'] == 'whereIn' && is_array($wp['value'])) {
                    $operatorConditional = 'whereIn';
                } else {
                    if ($wp['conditional'] == '' || $wp['conditional'] == null) {
                        $conditional = 'and';
                    } else {
                        if (strtolower(trim($wp['conditional'], ' ')) == 'and') {
                            $conditional = 'and';
                        } elseif (strtolower(trim($wp['conditional'], ' ')) == 'or') {
                            $conditional = 'or';
                        } else {
                            $conditional = 'and';
                        }
                    }
                }
            } else {
                $conditional = 'and';
            }

            if ($operatorConditional == 'where') {
                if ($wp['value'] == null) {
                    $statementWhere .= sprintf(' %s is null %s', $wp['field'], $index != count($this->whereParams) - 1 ? $conditional : '');
                } else {
                    if (is_array($wp['field'])) {
                        $statementWhere .= sprintf(' concat (%s) %s :%s %s', implode(", ' ', ", $wp['field']), $operator, implode('', $fieldClean), $index != count($this->whereParams) - 1 ? $conditional : '');
                    } else {
                        $statementWhere .= sprintf(' %s %s :%s %s', $wp['field'], $operator, $fieldClean, $index != count($this->whereParams) - 1 ? $conditional : '');
                    }
                }
            } elseif ($operatorConditional == 'whereIn') {
                $statementWhere .= sprintf(' %s in %s %s', $wp['field'], is_array($wp['value']) ? '(' . implode(',', $wp['value']) . ')' : $wp['value'], $index != count($this->whereParams) - 1 ? $conditional : '');
            }
            $conditions[] = $statementWhere;
        }

        return $conditions;
    }
}
