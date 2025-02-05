<?php

namespace App\Application\Gateway\TelegramApi;

use App\Application\Gateway\BotMessageDTO\EditBotMessageDTO;
use App\Application\Gateway\BotMessageDTO\SendBotMessageDTO;

interface TelegramApiHttpClientInterface
{
    public function sendBotMessage(SendBotMessageDTO $sendBotMessageDTO): void;

    public function editBotMessage(EditBotMessageDTO $editBotMessageDTO): void;
}
