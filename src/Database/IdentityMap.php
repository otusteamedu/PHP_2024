<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Database;

class IdentityMap
{
    private array $items;

    public function getById(int $id): mixed
    {
        return $this->items[$id];
    }

    public function hasId(int $id): bool
    {
        return isset($this->items[$id]);
    }

    public function set(int $id, mixed $object): void
    {
        $this->items[$id] = $object;
    }

    public function removeById(int $id): void
    {
        unset($this->items[$id]);
    }
}
