<?php

declare(strict_types=1);

namespace Pozys\Php2024;

class IdentityMap
{
    private array $map = [];

    public function add(object $object, int|string $id): void
    {
        $this->map[$this->getKey(get_class($object), $id)] = $object;
    }

    public function remove(string $class, int|string $id): void
    {
        unset($this->map[$this->getKey($class, $id)]);
    }

    public function hasObject(string $class, int|string $id): bool
    {
        return array_key_exists($this->getKey($class, $id), $this->map);
    }

    public function get(string $class, int|string $id): object
    {
        if (!$this->hasObject($class, $id)) {
            throw new \RuntimeException("Object not found in identity map");
        }

        return $this->map[$this->getKey($class, $id)];
    }

    private function getKey(string $class, int|string $id): string
    {
        return "$class.$id";
    }
}
