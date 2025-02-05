<?php

namespace App\Controller\Amqp\SendMessage;

use App\Application\Gateway\BotMessageDTO\SendBotMessageDTO;
use App\Application\Gateway\TelegramApi\TelegramApiHttpClientInterface;
use App\Application\RabbitMq\AbstractConsumer;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly TelegramApiHttpClientInterface $telegramApiHttpClient,
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
        $this->telegramApiHttpClient->sendBotMessage(
            new SendBotMessageDTO(
                $message->useCase,
                $message->chatId,
                $message->parseMode,
                $message->text,
                $message->replyMarkup,
            )
        );

        return self::MSG_ACK;
    }
}
