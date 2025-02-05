<?php

namespace App\Controller\Cli\CodeceptionSupportCommand;

use App\Controller\Cli\CodeceptionSupportCommand\CodeceptionSupportCommandEnum\CodeceptionSupportCommandEnum;
use Support\Data\UpdateForEachUseCase\PlanShoppingTwoItems;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Domain\DTO\Search\SearchTestMessageDTO;
use Symfony\Component\Console\Command\Command;
use App\Domain\Service\MessageService;
use Telegram\Bot\Objects\Update;
use App\Domain\Entity\Purchase;
use App\Domain\Entity\Message;

#[AsCommand(name: self::COMMAND_NAME, description: 'Parent command for CodeceptionSupportCommand', hidden: true)]
class AbstractCodeceptionSupportCommand extends Command
{
    public const COMMAND_NAME = CodeceptionSupportCommandEnum::FindAndRemoveTestMessageCommandName->value;
    private const MESSAGE_SUCCESS = CodeceptionSupportCommandEnum::CommandMessageSuccess->value;

    public function __construct(
        private readonly MessageService $messageService,
        private readonly SerializerInterface $serializer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    protected function checkItemInDB(): array
    {
        $messageArray = $this->messageService->findTestMessage($this->buildSearchTestMessageDTO());
        if ( ! ($messageArray[0] instanceof Message)) {
            return [self::FAILURE, 'Error: message not found'];
        }

        $purchaseArray = ($messageArray[0])->getPurchases()->toArray();
        if ( ! ($purchaseArray[0] instanceof Purchase)) {
            return [self::FAILURE, 'Error: test purchase one not found'];
        }

        if ( ! ($purchaseArray[1] instanceof Purchase)) {
            return [self::FAILURE, 'Error: test purchase two not found'];
        }

        return [self::SUCCESS, self::MESSAGE_SUCCESS];
    }

    protected function checkPurchaseMarkedAsPurchasedInDB(): array
    {
        $messageArray = $this->messageService->findTestMessage($this->buildSearchTestMessageDTO());
        $purchaseArray = ($messageArray[0])->getPurchases()->toArray();
        if ( ! ($purchaseArray[0]->getIsPurchased() || $purchaseArray[1]->getIsPurchased())) {
            return [self::FAILURE, 'Error: test purchase one not marked as purchase'];
        }

        return [self::SUCCESS, self::MESSAGE_SUCCESS];
    }

    protected function removeItemFromDB(): array
    {
        $messageArray = $this->messageService->findTestMessage($this->buildSearchTestMessageDTO());
        $this->messageService->removeMessageArray($messageArray);
        $messageArray = $this->messageService->findTestMessage($this->buildSearchTestMessageDTO());
        if (count($messageArray) > 0) {
            return [self::FAILURE, 'Error: message not removed'];
        }

        return [self::SUCCESS, self::MESSAGE_SUCCESS];
    }

    protected function getTestPurchaseId(): array
    {
        $messageArray = $this->messageService->findTestMessage($this->buildSearchTestMessageDTO());
        $purchaseArray = ($messageArray[0])->getPurchases()->toArray();

        return [self::SUCCESS, $purchaseArray[0]->getId() . ';' . $purchaseArray[1]->getId()];
    }

    protected function buildSearchTestMessageDTO(): SearchTestMessageDTO
    {
        $update = (new PlanShoppingTwoItems())::getUpdateArrayForObject();
        /** @var Update $update */
        $update = $this->serializer->deserialize(json_encode($update), 'Telegram\Bot\Objects\Update', 'json');

        return new SearchTestMessageDTO(
            $update->updateId,
            $update->message->messageId,
            $update->message->chat->id,
            $update->message->from->id,
            $update->message->date,
            $update->message->text,
        );
    }
}
