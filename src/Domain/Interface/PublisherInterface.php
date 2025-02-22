<?php

declare(strict_types=1);

namespace App\Domain\Interface;

interface PublisherInterface
{
    public function subscribe(string $event, string $listener): void;

    public function unsubscribe(string $event, string $listener): void;

    public function notify(EventInterface $event): void;
}
