<?php

namespace KRudenko\Otus\Service\Storage;

interface StorageInterface
{
    public function addEvent(array $event): int;

    public function clearEvents(): void;

    public function getAllEventsSortedByPriority(): array;
}
