<?php

namespace App\Application\BotCommandHandler;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use App\Application\UseCase\DoShopping\DoShoppingUseCase;
use Telegram\Bot\Objects\Update;

class CallbackQueryHandler
{
    public function __construct(
        private readonly DoShoppingUseCase $shoppingListHandler
    ) {
    }

    public function handleCallbackQuery(Update $update): void
    {
        match (BotCommandEnum::tryFrom($this->getCommand($update))) {
            BotCommandEnum::ItemRemove => $this->shoppingListHandler->removeItemFromShoppingList($update)
        };
    }

    private function getCommand(Update $update): string
    {
        $commandSeparatorIndex = stripos($update->callbackQuery->data, BotCommandEnum::CommandSeparator->value);

        return substr($update->callbackQuery->data, 0, $commandSeparatorIndex);
    }
}
