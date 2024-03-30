<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\Repository;

use Rmulyukov\Hw\Application\Event\Event;

interface EventCommandRepositoryInterface
{
    public function add(Event $event): bool;
    public function clear(): bool;
}
