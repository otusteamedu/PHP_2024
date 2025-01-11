<?php

namespace App\Storage;

interface EventStorageInterface
{
    public function addEvent(array $event): void;
    public function clearEvents(): void;
    public function getBestMatchingEvent(array $params): ?array;
}
