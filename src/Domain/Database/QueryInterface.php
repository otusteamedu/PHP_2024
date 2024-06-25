<?php

declare(strict_types=1);

namespace App\Domain\Database;

interface QueryInterface
{
    public function getNewsByUuid(string $uuid): array;
}
