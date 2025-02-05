<?php

namespace App\Domain\Bus;

use App\Domain\DTO\Bus\ChatUpdateDTO;

interface ChatUpdateBusInterface
{
    public function handleChatUpdate(ChatUpdateDTO $chatUpdateDTO): bool;
}
