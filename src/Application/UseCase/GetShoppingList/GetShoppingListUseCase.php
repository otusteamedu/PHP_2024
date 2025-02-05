<?php

namespace App\Application\UseCase\GetShoppingList;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use App\Application\TextMessageEnum\TextMessageEnum;
use App\Domain\DTO\Bus\SendMessageDTO;
use App\Domain\Service\AsyncBusService;
use App\Domain\Service\MessageService;
use ReflectionClass;
use Telegram\Bot\Objects\Update;

class GetShoppingListUseCase
{
    public function __construct(
        private readonly MessageService  $messageService,
        private readonly AsyncBusService $asyncBusService,
    ) {
    }

    public function __invoke(Update $update): void
    {
        $chatId = $update->message->chat->id;
        $purchaseArray = $this->messageService->getItemNotPurchasedByChatId($chatId);

        $text = TextMessageEnum::ShoppingListEmpty->value;
        if ($purchaseArray) {
            $inlineKeyboard = [];
            foreach ($purchaseArray as $purchase) {
                $inlineKeyboard[] = [[
                    'text' => $purchase->title,
                    'callback_data' => BotCommandEnum::ItemRemove->value
                        . BotCommandEnum::CommandSeparator->value . $purchase->id
                ]];
            }
            $replyMarkup = json_encode(["inline_keyboard" => $inlineKeyboard], JSON_UNESCAPED_UNICODE);
            $text = TextMessageEnum::ShoppingList->value;
        }

        $this->asyncBusService->sendBotMessageByAsyncBus(
            new SendMessageDTO(
                (new ReflectionClass($this))->getShortName(),
                $chatId,
                BotCommandEnum::ParseModeDefault->value,
                '*' . $text . '*',
                $replyMarkup ?? null,
            )
        );
    }
}
