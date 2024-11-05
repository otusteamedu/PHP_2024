<?php

declare(strict_types=1);

namespace Irayu\Hw13\Infrastructure\Repository;

class IdentityMap
{
    private array $map = [];

    public function get($entityClass, $id): mixed
    {
        return $this->map[$entityClass][$id] ?? null;
    }

    public function add($entity): static
    {
        $entityClass = get_class($entity);
        $id = $entity->getId();
        $this->map[$entityClass][$id] = $entity;

        return $this;
    }

    public function update($entity): static
    {
        $this->add($entity);

        return $this;
    }
}
