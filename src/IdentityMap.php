<?php

declare(strict_types=1);

namespace Amikha1lov\DataMapper;

class IdentityMap
{
    private array $map;

    public function get(string $className, int $id): ?Entity
    {
        return $this->map[$className][$id] ?? null;
    }

    public function add(Entity $entity): void
    {
        $className = $entity::class;

        $this->map[$className] ??= [];
        $this->map[$className][$entity->getId()] = $entity;
    }

}
