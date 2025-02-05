<?php

namespace App\Domain\Model\Message;

use Doctrine\Common\Collections\Collection;

class MessageModel
{
    public function __construct(
        public int $updateId,
        public int $chatId,
        public int $messageId,
        public int $telegramUserId,
        public bool $isBot,
        public string $firstName,
        public string $userName,
        public string $text,
        public ?Collection $purchases,
        public int $date,
    ) {
    }
}
