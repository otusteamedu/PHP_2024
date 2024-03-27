<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application\Repository;

use Rmulyukov\Hw11\Application\Dto\ItemsDto;

interface ShopCommandRepositoryInterface
{
    public function initStorage(string $storageName, array $settings): array;
    public function addItems(string $storageName, ItemsDto $items): array;
}
