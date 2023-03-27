<?php

namespace Sophy\Database\Drivers\Interfaces;

interface IInsertQueryBuilder extends IQueryBuilder
{
    public function columns(string ...$columns): self;

}