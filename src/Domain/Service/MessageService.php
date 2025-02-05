<?php

namespace App\Domain\Service;

use App\Domain\DTO\Search\SearchTestMessageDTO;
use App\Domain\Entity\Purchase;
use App\Domain\Model\CheckListItem\CheckListItemModel;
use App\Domain\Model\Message\MessageModel;
use App\Domain\Entity\Message;
use App\Domain\RepositoryInterface\MessageRepositoryInterface;

class MessageService
{
    # Инъекция зависимости без конструктора + см. services.yaml
//    private readonly MessageRepositoryInterface $messageRepository;

    public function __construct(
        private readonly MessageRepositoryInterface $messageRepository,
        private readonly PurchaseService            $purchaseService,
    ) {
    }

    # Инъекция зависимости без конструктора + см. services.yaml
//    public function setMessageRepository(MessageRepositoryInterface $messageRepository): void
//    {
//        $this->messageRepository = $messageRepository;
//    }

    public function createMessage(MessageModel $messageModel): Message
    {
        $message = new Message();
        $message->setUpdateId($messageModel->updateId);
        $message->setChatId($messageModel->chatId);
        $message->setMessageId($messageModel->messageId);
        $message->seTelegramUserId($messageModel->telegramUserId);
        $message->setIsBot($messageModel->isBot);
        $message->setFirstName($messageModel->firstName);
        $message->setUserName($messageModel->userName);
        $message->setText($messageModel->text);
        $message->setPurchases($messageModel->purchases);
        $message->setDate($messageModel->date);

        $this->messageRepository->createMessage($message);

        return $message;
    }

    /**
     * @param int $chatId
     * @return CheckListItemModel[]
     */
    public function getItemNotPurchasedByChatId(int $chatId): array
    {
        $messageArray = $this->getMessageByChatId($chatId);
        $totalPurchaseArray = [];

        foreach ($messageArray as $message) {
            $messagePurchaseArray = $message->getPurchases()->toArray();

            foreach ($messagePurchaseArray as $purchase) {
                /** @var Purchase $purchase */
                if (!$purchase->getIsPurchased()) {
                    $item = new CheckListItemModel(
                        $purchase->getId(),
                        $purchase->getTitle(),
                        $message->getFirstName(),
                        gmdate('d-m-y', $message->getDate()),
                    );
                    $totalPurchaseArray[] = $item;
                }
            }
        }

        return $totalPurchaseArray;
    }

    /**
     * @param int $chatId
     * @return Message[]
     */
    public function getMessageByChatId(int $chatId): array
    {
        return $this->messageRepository->getMessageByChatId($chatId);
    }

    /**
     * @param SearchTestMessageDTO $searchTestMessageDTO
     * @return Message[]
     */
    public function findTestMessage(SearchTestMessageDTO $searchTestMessageDTO): array
    {
        return $this->messageRepository->findTestMessage($searchTestMessageDTO);
    }

    public function remove(Message $message): bool
    {
        $this->messageRepository->remove($message);

        $purchaseArray = $message->getPurchases()->toArray();
        foreach ($purchaseArray as $purchase) {
            $this->purchaseService->remove($purchase);
        }

        return true;
    }

    /**
     * @param Message[] $messageArray
     * @return bool
     */
    public function removeMessageArray(array $messageArray): bool
    {
        foreach ($messageArray as $message) {
            $this->remove($message);
        }

        return true;
    }
}
