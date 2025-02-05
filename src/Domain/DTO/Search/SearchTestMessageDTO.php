<?php

namespace App\Domain\DTO\Search;

class SearchTestMessageDTO
{
    public function __construct(
        public readonly int $updateId,
        public readonly int $messageId,
        public readonly int $chatId,
        public readonly int $userId,
        public readonly int $date,
        public readonly string $text
    ) {
    }
}
