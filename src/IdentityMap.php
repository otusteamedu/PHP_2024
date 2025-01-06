<?php

declare(strict_types=1);

namespace Amikha1lov\DataMapper;

class IdentityMap
{
    private array $map;

    public function __construct()
    {
        $this->map = [];
    }

    public function get(int $id): ?Entity
    {
        foreach ($this->map as $entity) {
            if ($entity->getId() === $id) {
                return $entity;
            }
        }
        return null;
    }

    public function add(Entity $entity): void
    {
        $objectHash = spl_object_id($entity); // spl_object_hash

        $this->map[$objectHash] ??= [];
        $this->map[$objectHash] = $entity;
    }
}
