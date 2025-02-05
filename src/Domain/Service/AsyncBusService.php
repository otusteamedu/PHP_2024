<?php

namespace App\Domain\Service;

use App\Domain\Bus\ChatUpdateBusInterface;
use App\Domain\Bus\EditMessageBusInterface;
use App\Domain\Bus\SendMessageBusInterface;
use App\Domain\DTO\Bus\ChatUpdateDTO;
use App\Domain\DTO\Bus\EditMessageDTO;
use App\Domain\DTO\Bus\SendMessageDTO;

class AsyncBusService
{
    public function __construct(
        private readonly ChatUpdateBusInterface  $chatUpdateBus,
        private readonly SendMessageBusInterface $sendMessageBus,
        private readonly EditMessageBusInterface $editMessageBus,
    ) {
    }

    public function handleChatUpdateByAsyncBus(ChatUpdateDTO $chatUpdateDTO): bool
    {
        return $this->chatUpdateBus->handleChatUpdate($chatUpdateDTO);
    }

    public function sendBotMessageByAsyncBus(SendMessageDTO $sendMessageDTO): bool
    {
        return $this->sendMessageBus->sendMessage($sendMessageDTO);
    }

    public function editBotMessageByAsyncBus(EditMessageDTO $editMessageDTO): bool
    {
        return $this->editMessageBus->editMessage($editMessageDTO);
    }
}
