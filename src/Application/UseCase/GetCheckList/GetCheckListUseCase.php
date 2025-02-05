<?php

namespace App\Application\UseCase\GetCheckList;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use App\Application\TextMessageEnum\TextMessageEnum;
use App\Domain\DTO\Bus\SendMessageDTO;
use App\Domain\Service\AsyncBusService;
use App\Domain\Service\MessageService;
use ReflectionClass;
use Telegram\Bot\Objects\Update;
use Twig\Environment;

class GetCheckListUseCase
{
    public function __construct(
        private readonly MessageService  $messageService,
        private readonly AsyncBusService $asyncBusService,
        private readonly Environment $twig,
    ) {
    }

    public function __invoke(Update $update): void
    {
        $chatId = $update->message->chat->id;
        $purchaseArray = $this->messageService->getItemNotPurchasedByChatId($chatId);

        $checkList = $this->getHtml($purchaseArray);

        $this->asyncBusService->sendBotMessageByAsyncBus(
            new SendMessageDTO(
                (new ReflectionClass($this))->getShortName(),
                $chatId,
                BotCommandEnum::ParseModeHtml->value,
                $checkList,
                null
            )
        );
    }

    private function getHtml(array $purchaseArray): string
    {
        $title = TextMessageEnum::ShoppingListEmpty->value;
        if ($purchaseArray) {
            $title = TextMessageEnum::CheckList->value;
        }

        return $this->twig->render('bot-message/check-list.html.twig', [
            'title' => $title,
            'items' => $purchaseArray,
        ]);
     }

    private function getMarkdown(array $purchaseArray): string
    {
        $checkList = '*' . TextMessageEnum::ShoppingListEmpty->value . '*' . PHP_EOL;
        if ($purchaseArray) {
            $checkList = '*' . TextMessageEnum::CheckList->value . '*' . PHP_EOL;
            foreach ($purchaseArray as $index => $purchase) {
                $checkList .= '*' . ++$index . '. ' . $purchase->title . '*'
                    . ' (' . $purchase->firstName . ', ' . $purchase->date . ')' . PHP_EOL;
            }
        }

        return $checkList;
    }
}
