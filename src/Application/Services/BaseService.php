<?php

namespace Sophy\Application\Services;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\Configuration\AutoMapperConfig;

abstract class BaseService
{
    const DEFAULT_PER_PAGE_PAGINATION = 2000;

    protected AutoMapperConfig $config;
    protected AutoMapper $mapper;

    public function __construct()
    {
        $this->config = new AutoMapperConfig();
        $this->mapper = new AutoMapper($this->config);
    }
}
