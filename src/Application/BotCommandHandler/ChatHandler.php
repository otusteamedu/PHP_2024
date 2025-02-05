<?php

namespace App\Application\BotCommandHandler;

use App\Application\UseCase\PlanShopping\PlanShoppingUseCase;
use Telegram\Bot\Objects\Update;

class ChatHandler
{
    public function __construct(
        private readonly CallbackQueryHandler $callbackQueryHandler,
        private readonly CommandHandler       $commandHandler,
        private readonly PlanShoppingUseCase  $planShoppingUseCase,
    ) {
    }

    public function handleChatUpdate(Update $update): void
    {
        if (isset($update->callbackQuery)) {
            $this->callbackQueryHandler->handleCallbackQuery($update);
        }

        if (isset($update->message->entities)) {
            $this->commandHandler->handleCommand($update);
        }

        if (!isset($update->message->entities) && !isset($update->callbackQuery)) {
            ($this->planShoppingUseCase)($update);
        }
    }
}
