<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Repositories\EventSystem;

use RailMukhametshin\Hw\Dto\EventSystem\EventObject;

interface EventRepositoryInterface
{
    public function add(EventObject $eventObject): void;
    public function removeAll(): void;
    public function getByParams(array $params): ?EventObject;
    public function getAll(): array;
}
