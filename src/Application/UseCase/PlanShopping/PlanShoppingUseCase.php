<?php

namespace App\Application\UseCase\PlanShopping;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use App\Domain\Factory\ModelFactory;
use App\Domain\Model\Message\MessageModel;
use App\Domain\Model\Purchase\PurchaseModel;
use App\Domain\Service\MessageService;
use App\Domain\Service\PurchaseService;
use Doctrine\Common\Collections\ArrayCollection;
use Telegram\Bot\Objects\Update;

class PlanShoppingUseCase
{
    public function __construct(
        private readonly MessageService       $messageService,
        private readonly PurchaseService      $purchaseService,
        private readonly ModelFactory         $modelFactory,
    ) {
    }

    public function __invoke(Update $update): void
    {
        $itemArray = explode(BotCommandEnum::PurchaseSeparatorDot->value, $update->message->text);

        $purchaseArray = [];
        foreach ($itemArray as $item) {
            $purchaseModel   = $this->modelFactory->makeModel(
                PurchaseModel::class,
                trim($item),
                false,
                null,
                null,
                null,
                null,
                null,
            );
            $purchaseArray[] = $this->purchaseService->createPurchase($purchaseModel);
        }

        $purchaseCollection = new ArrayCollection($purchaseArray);

        $messageModel = $this->modelFactory->makeModel(
            MessageModel::class,
            $update->updateId,
            $update->message->chat->id,
            $update->message->messageId,
            $update->message->from->id,
            $update->message->from->isBot,
            $update->message->from->firstName,
            $update->message->from->username,
            $update->message->text,
            $purchaseCollection,
            $update->message->date,
        );

        $this->messageService->createMessage($messageModel);
    }
}
