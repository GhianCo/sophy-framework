<?php

namespace Sophy\Database\Drivers;

interface IDBDriver {
    public function connect(
        string $protocol,
        string $host,
        int $port,
        string $database,
        string $username,
        string $password
    );

    public function lastInsertId();

    public function close();

    public function statement(string $query, array $bind = []);

    public function query(string $query);
}
