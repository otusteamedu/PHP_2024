<?php

namespace Support\Helper;

use App\Application\BotCommandHandler\ChatHandler;
use App\Domain\Entity\Purchase;
use App\Domain\Service\MessageService;
use App\Tests\Support\FunctionalTester;
use Codeception\Test\Unit;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Telegram\Bot\Objects\Update;
use Twig\Environment;

class AbstractFunctionalHelper extends Unit
{
    protected string                $file;
    protected ChatHandler           $chatHandler;
    protected MessageService        $messageService;
    protected FunctionalTester      $tester;
    protected SerializerInterface   $serializer;
    protected ParameterBagInterface $parameterBag;
    protected Environment           $twig;

    protected function _before(): void
    {
        $this->parameterBag   = $this->tester->grabService(ParameterBagInterface::class);
        $this->serializer     = $this->tester->grabService(SerializerInterface::class);
        $this->messageService = $this->tester->grabService(MessageService::class);
        $this->chatHandler    = $this->tester->grabService(ChatHandler::class);
        $this->twig           = $this->tester->grabService(Environment::class);

//        $this->file = $this->parameterBag->get('bot_message_log_path')
//                        . '-' . (new \DateTime())->format('Y-m-d') . '.log';
//        chmod($this->file, 0666);
        $this->file = $this->getFilePath();
        file_put_contents($this->file, '');
    }
    protected function getCheckList(): void
    {
        $update = $this->getUpdateObject('GetCheckList');
        $this->chatHandler->handleChatUpdate($update);
    }

    protected function CreateItemOfShoppingList(): Update
    {
        $updateWithItems = $this->getUpdateObject('PlanShoppingTwoItems');
        $this->chatHandler->handleChatUpdate($updateWithItems);

        return $updateWithItems;
    }

    protected function getShoppingListUpdate(): Update
    {
        $update = $this->getUpdateObject('GetShoppingList');
        $this->chatHandler->handleChatUpdate($update);

        return $update;
    }

    protected function getPurchaseIdArrayByUpdate(Update $updateWithItems): array
    {
        $message = $this->messageService->getMessageByChatId($updateWithItems->message->chat->id)[0];
        $purchaseArray = $message->getPurchases()->toArray();
        $purchaseIdArray = [];
        foreach ($purchaseArray as $purchase) {
            /** @var Purchase $purchase */
            $purchaseIdArray[] = $purchase->getId();
        }

        return $purchaseIdArray;
    }

    protected function getExpectedPurchaseArray(Update $update): array
    {
        if (isset($update->callbackQuery)) {
            return $this->messageService->getMessageByChatId($update->callbackQuery->message->chat->id)[0]->getPurchases()->toArray();
        }

        return $this->messageService->getMessageByChatId($update->message->chat->id)[0]->getPurchases()->toArray();
    }

    protected function getDataFromLog(): string
    {
        for ($i = 1; $i < 9; $i++) {
            sleep($i);
            $dataFromLog = file_get_contents($this->file);
            if ($dataFromLog !== '') {
                break;
            }
        }

        return $dataFromLog;
    }

    protected function getUpdateObject(string $updateExampleClassName, array $idArray = null): Update
    {
        $updateExampleClassName = 'Support\Data\UpdateForEachUseCase\\'. $updateExampleClassName;
        $update = (new $updateExampleClassName())::getUpdateArrayForObject($idArray);

        return $this->serializer->deserialize(json_encode($update), 'Telegram\Bot\Objects\Update', 'json');
    }

    protected function getMarkdownForTestGetShoppingListWithItems(array $arrayId)
    {
        return
            '{"chat_id":-1002453281390,"parse_mode":"Markdown","text":"*Список покупок для шоппинга:*","reply_markup":"{\"inline_keyboard\":[[{\"text\":\"test purchase one\",\"callback_data\":\"remove@' . $arrayId[0] . '\"}],[{\"text\":\"test purchase two\",\"callback_data\":\"remove@' . $arrayId[1] . '\"}]]}"';
    }

    protected function getMarkdownForTestRemoveItemFromShoppingListUpdate(int $id)
    {
        return
            '{"chat_id":-1002453281390,"message_id":-1,"parse_mode":"Markdown","text":"*Список покупок для шоппинга:*","reply_markup":"{\"inline_keyboard\":[[{\"text\":\"test purchase two\",\"callback_data\":\"remove@' . $id . '\"}]]}"}';
    }

    private function getFilePath(): string
    {
        $file = $this->parameterBag->get('bot_message_log_path') . '.log';

        if ($this->parameterBag->get('app_env') === 'prod') {
            $file = $this->parameterBag->get('bot_message_log_path')
                . '-' . (new \DateTime())->format('Y-m-d') . '.log';
        }
        chmod($file, 0666);

        return $file;
    }
}
