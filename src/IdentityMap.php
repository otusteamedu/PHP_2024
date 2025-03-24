<?php

namespace App;

class IdentityMap
{
    private array $objects = [];

    public function get(string $class, int $id): ?object
    {
        return $this->objects[$class][$id] ?? null;
    }

    public function add(object $object, int $id): void
    {
        $class = get_class($object);
        $this->objects[$class][$id] = $object;
    }
}
