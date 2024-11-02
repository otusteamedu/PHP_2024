<?php

namespace VSukhov\Hw14\Gate;

class IdentityMap
{
    private array $map = [];

    public function add(int $id, array $data): void
    {
        $this->map[$id] = $data;
    }

    public function get(int $id): ?array
    {
        return $this->map[$id] ?? null;
    }
}
