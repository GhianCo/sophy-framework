<?php

namespace Sophy\Database\Drivers;

use PDO;

class PdoDriver implements IDBDriver {
    protected ?PDO $pdo;

    public function connect(
        string $protocol,
        string $host,
        int $port,
        string $database,
        string $username,
        string $password
    ) {
        $dsn = "$protocol:host=$host;port=$port;dbname=$database";
        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function close() {
        $this->pdo = null;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function statement(string $query, array $bind = []) {
        $statement = $this->pdo->prepare($query);
        $statement->execute($bind);
        return $statement;
    }

    public function query(string $query) {
        return $this->pdo->query($query);
    }
}
