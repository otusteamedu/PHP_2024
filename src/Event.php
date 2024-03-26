<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

use AleksandrOrlov\Php2024\Storage\Base;

class Event
{
    private Base $storage;

    public function __construct(Base $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param int $priority
     * @param array $conditions
     * @param string $event
     * @return void
     */
    public function add(int $priority, array $conditions, string $event): void
    {
        $this->storage->add($priority, $conditions, $event);
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->storage->clear();
    }

    /**
     * @param $params
     * @return string|null
     */
    public function get($params): ?string
    {
        return $this->storage->get($params);
    }
}
