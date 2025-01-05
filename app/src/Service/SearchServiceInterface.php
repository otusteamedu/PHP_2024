<?php

declare(strict_types=1);

namespace App\Service;

interface SearchServiceInterface
{
    public function search(array $params): ?array;
}
