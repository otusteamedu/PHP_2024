<?php

declare(strict_types=1);

namespace App\Application\UseCase;

interface MessageBrokerInterface
{
    public function publish(array $data): void;
}
