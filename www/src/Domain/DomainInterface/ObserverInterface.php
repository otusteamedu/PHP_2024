<?php

declare(strict_types=1);

namespace App\Domain\DomainInterface;

interface ObserverInterface
{
    public function handleNotification(array $data = []);

    public function getID(): string|int;
}