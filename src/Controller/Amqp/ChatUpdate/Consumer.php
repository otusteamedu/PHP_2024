<?php

namespace App\Controller\Amqp\ChatUpdate;

use App\Application\BotCommandHandler\ChatHandler;
use App\Application\RabbitMq\AbstractConsumer;
use Symfony\Component\Serializer\SerializerInterface;
use Telegram\Bot\Objects\Update;


class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ChatHandler $chatHandler,
    ) {
    }

    protected function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @param Message $message
     */
    protected function handle($message): int
    {
        /** @var Update $update */
        $update = $this->serializer->deserialize($message->data, 'Telegram\Bot\Objects\Update', 'json');

        $this->chatHandler->handleChatUpdate($update);

        return self::MSG_ACK;
    }
}
