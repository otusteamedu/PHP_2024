<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application\Repository;

use Rmulyukov\Hw11\Application\Dto\QueryDto;

interface ShopQueryRepositoryInterface
{
    public function findAll(string $storageName, QueryDto $query): array;
}
