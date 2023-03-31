<?php

namespace Sophy\Database\Drivers\Interfaces;

interface ISelectQueryBuilder extends IQueryBuilder {
    public function select(string ...$select): self;

    public function callFoundRows(bool $withCallFoundRows): self;

    public function where(array $conditions): self;

    public function whereColumn(string $field, string $operator, string $contional): self;

    public function first(): self;

    public function page(int $page): self;

    public function perPage(int $perPage): self;

    public function orderBy(string ...$order): self;

    public function innerJoin(string ...$innerJoin): self;

    public function leftJoin(string ...$leftJoin): self;

    public function rightJoin(string ...$rightJoin): self;
}
