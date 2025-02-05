<?php

namespace App\Domain\RepositoryInterface;

use App\Domain\Entity\Message;

interface MessageRepositoryInterface
{
    public function createMessage(Message $message): int;

    /**
     * @param int $chatId
     * @return Message[]
     */
    public function getMessageByChatId(int $chatId): array;
}
