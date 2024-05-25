<?php

declare(strict_types=1);

namespace App\Domain\Observer;

interface ObserverInterface
{
    public function handleNotification(callable $callback): void;

    public function getID(): string|int;
}