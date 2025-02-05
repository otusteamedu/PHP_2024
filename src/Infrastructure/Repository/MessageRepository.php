<?php

namespace App\Infrastructure\Repository;

use App\Domain\DTO\Search\SearchTestMessageDTO;
use App\Domain\Entity\Message;
use App\Domain\RepositoryInterface\MessageRepositoryInterface;

class MessageRepository extends AbstractRepository implements MessageRepositoryInterface
{
    public function createMessage(Message $message): int
    {
        return $this->store($message);
    }

    /**
     * @param int $chatId
     * @return Message[]
     */
    public function getMessageByChatId(int $chatId): array
    {
        return $this->entityManager->getRepository(Message::class)->findBy(['chatId' => $chatId], ['date' => 'ASC']);
    }

    /**
     * @param SearchTestMessageDTO $searchTestMessageDTO
     * @return Message[]
     */
    public function findTestMessage(SearchTestMessageDTO $searchTestMessageDTO): array
    {
        return $this->entityManager->getRepository(Message::class)->findBy([
            'updateId'       => $searchTestMessageDTO->updateId,
            'messageId'      => $searchTestMessageDTO->messageId,
            'chatId'         => $searchTestMessageDTO->chatId,
            'telegramUserId' => $searchTestMessageDTO->userId,
            'date'           => $searchTestMessageDTO->date,
            'text'           => $searchTestMessageDTO->text,
        ]);
    }

    public function remove(Message $message): void
    {
        $this->entityManager->remove($message);
        $this->flush();
    }
}
