<?php

namespace VladimirGrinko\Patterns\Factory;

class CookingEventFactory
{
    public static function createEvent(string $type): CookingEventInterface
    {
        return match ($type) {
            'before' => new BeforeCooking(),
            'after' => new AfterCooking(),
            'dispose' => new DisposalEvent(),
            default => throw new \Exception("Неизвестное событие: $type"),
        };
    }
}
