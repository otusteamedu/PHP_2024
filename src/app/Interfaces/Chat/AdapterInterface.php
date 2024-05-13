<?php

declare(strict_types=1);

namespace App\Interfaces\Chat;

use Generator;

interface AdapterInterface
{
    public function run(): Generator;
}