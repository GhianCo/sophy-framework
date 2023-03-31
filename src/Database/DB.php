<?php

namespace Sophy\Database;

use Sophy\Database\Drivers\IDBDriver;

class DB {
    public static function statement(string $query, array $bind = []) {
        return app(IDBDriver::class)->statement($query, $bind);
    }

    public static function query(string $query) {
        return app(IDBDriver::class)->query($query);
    }
}
