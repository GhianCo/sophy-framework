<?php

namespace Sophy\Database\Drivers\Mysql;

trait GroupByClause {
    use ProcessClause;

    public function groupBy(...$groups) {
        $arr = [];
        foreach ($groups as $group) {
            $arr[] = $this->fix_column_name($group)['name'];
        }
        $this->addToSourceArray('GROUP_BY', "GROUP BY " . implode(',', $arr));
        return $this;
    }
}
