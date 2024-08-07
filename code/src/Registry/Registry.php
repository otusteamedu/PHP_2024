<?php

declare(strict_types=1);

namespace Viking311\Analytics\Registry;

use Viking311\Analytics\Registry\Adapter\AdapterInterface;

class Registry
{
    public function __construct(private AdapterInterface $adapter)
    {
    }
}
