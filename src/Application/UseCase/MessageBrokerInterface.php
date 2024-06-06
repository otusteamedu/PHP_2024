<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Application\UseCase;

interface MessageBrokerInterface
{
    public function publish(array $data): void;
}
