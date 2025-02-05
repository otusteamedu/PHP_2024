<?php

namespace App\Application\Gateway\BotMessageDTO;

class EditBotMessageDTO
{
    public function __construct(
        public readonly string  $useCase,
        public readonly int     $chatId,
        public readonly int     $messageId,
        public readonly ?string $parseMode,
        public readonly string  $text,
        public readonly ?string $replyMarkup,
    ) {
    }
}
