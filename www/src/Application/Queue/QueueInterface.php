<?php

declare(strict_types=1);

namespace App\Application\Queue;

interface QueueInterface
{
    public function pushMessage(MessageDTO $message): bool;

    public function getMessageOrNull(): ?MessageDTO;
}