<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Application\Dto;

final readonly class ItemsDto
{
    public function __construct(
        private array|string $items
    ) {
    }

    public function getItems(): array|string
    {
        return $this->items;
    }
}
