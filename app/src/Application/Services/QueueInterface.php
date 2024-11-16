<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Entity\BankStatement;

interface QueueInterface
{
    public function addMessage(BankStatement $message): void;

    public function getMessage(callable $callback): void;
}
