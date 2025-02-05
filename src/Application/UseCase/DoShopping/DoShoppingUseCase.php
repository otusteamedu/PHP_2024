<?php

namespace App\Application\UseCase\DoShopping;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use App\Application\TextMessageEnum\TextMessageEnum;
use App\Domain\DTO\Bus\EditMessageDTO;
use App\Domain\Factory\ModelFactory;
use App\Domain\Model\ShoppingListItem\ShoppingListItemModel;
use App\Domain\Service\AsyncBusService;
use App\Domain\Service\PurchaseService;
use ReflectionClass;
use Telegram\Bot\Objects\Update;

class DoShoppingUseCase
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly PurchaseService $purchaseService,
        private readonly AsyncBusService $asyncBusService,
    ) {
    }

    public function removeItemFromShoppingList(Update $update): void
    {
        $inlineKeyboard = json_decode($update->callbackQuery->message->replyMarkup, true)['inline_keyboard'];
        $newInlineKeyboard = [];

        foreach ($inlineKeyboard as $row) {
            $newRow = [];
            foreach ($row as $item) {
                if (!in_array($update->callbackQuery->data, $item)) {
                    $newRow[] = $item;
                }
            }
            if (count($newRow) > 0) {
                $newInlineKeyboard[] = $newRow;
            }
        }

        $replyMarkup = json_encode(["inline_keyboard" => $newInlineKeyboard]);
        $text = count($newInlineKeyboard) === 0 ? TextMessageEnum::ShoppingListCompleted->value : TextMessageEnum::ShoppingList->value;

        $this->markItemAsPurchasedById($update);

        $this->asyncBusService->editBotMessageByAsyncBus(
            new EditMessageDTO(
                (new ReflectionClass($this))->getShortName(),
                $update->callbackQuery->message->chat->id,
                $update->callbackQuery->message->messageId,
                BotCommandEnum::ParseModeDefault->value,
                '*' . $text . '*',
                $replyMarkup
            )
        );
    }

    private function markItemAsPurchasedById(Update $update)
    {
        $shoppingListItemModel = $this->modelFactory->makeModel(
            ShoppingListItemModel::class,
            $this->getItemId($update),
            true,
            $update->callbackQuery->from->id,
            $update->callbackQuery->from->firstName,
            $update->callbackQuery->from->username,
            $update->callbackQuery->from->isBot,
            time(),
        );

        $this->purchaseService->markItemAsPurchasedById($shoppingListItemModel);
    }

    private function getItemId(Update $update): string
    {
        $commandSeparatorIndex = stripos($update->callbackQuery->data, BotCommandEnum::CommandSeparator->value);

        return trim(substr($update->callbackQuery->data, $commandSeparatorIndex + 1));
    }
}
