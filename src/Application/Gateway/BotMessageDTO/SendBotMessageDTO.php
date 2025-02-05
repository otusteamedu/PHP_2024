<?php

namespace App\Application\Gateway\BotMessageDTO;

class SendBotMessageDTO
{
    public function __construct(
        public readonly string  $useCase,
        public readonly int     $chatId,
        public readonly ?string $parseMode,
        public readonly string  $text,
        public readonly ?string $replyMarkup
    ) {
    }
}
