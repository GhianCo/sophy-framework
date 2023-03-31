<?php

namespace Sophy\Database\Drivers\Interfaces;

interface IUpdateQueryBuilder extends IQueryBuilder {
    public function where(string ...$where): self;

    public function set(string ...$columns): self;
}
