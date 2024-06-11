<?php

declare(strict_types=1);

namespace App\Application\EventSourcing;

interface IEventListener
{
    public function execute(object $event): void;

    public function getSubscribedEventName(): string;
}
