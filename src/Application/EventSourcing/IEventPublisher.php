<?php

declare(strict_types=1);

namespace App\Application\EventSourcing;

interface IEventPublisher
{
    public function subscribe(string $eventType, IEventListener $eventListener): void;
    public function unSubscribe(string $eventType, IEventListener $eventListener): void;

    public function notify(object $event): void;
}
