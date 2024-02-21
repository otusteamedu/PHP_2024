<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Service;

use Generator;

interface NetworkInterface
{
    public function run(): Generator;
}
