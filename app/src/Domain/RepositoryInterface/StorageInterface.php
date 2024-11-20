<?php

namespace Kagirova\Hw15\Domain\RepositoryInterface;

use Kagirova\Hw15\Domain\Entity\Event;

interface StorageInterface
{
    public function set(Event $event): void;

    public function get($options): ?Event;

    public function clear(): void;
}
