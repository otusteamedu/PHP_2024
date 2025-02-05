<?php

namespace App\Domain\Bus;

use App\Domain\DTO\Bus\SendMessageDTO;

interface SendMessageBusInterface
{
    public function sendMessage(SendMessageDTO $sendMessageDTO): bool;
}
