<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Console\Consumer\Service\MessageConsume;

use AlexanderGladkov\Broker\Exchange\ConsumerInterface;
use AlexanderGladkov\Broker\Exchange\MessageInterface;
use AlexanderGladkov\Broker\Service\Logger\LoggerFactory;
use AlexanderGladkov\Broker\Service\Mail\MailServiceInterface;
use Throwable;

class MessageConsumeService
{
    public function __construct(
        private ConsumerInterface $consumer,
        private MailServiceInterface $mailService
    ) {
    }

    public function startConsume(): void
    {
        echo 'Ожидание сообщений...' . PHP_EOL . PHP_EOL;
        $this->consumer->consume(function (MessageInterface $message) {
            $this->processMessage($message);
        });
    }

    private function processMessage(MessageInterface $message)
    {
        $decodedBody = json_decode($message->getContent(), true);
        $email = $decodedBody['email'];
        $text = $decodedBody['text'];

        try {
            echo 'Обработка сообщения...' . PHP_EOL;
            echo $text . PHP_EOL;
            sleep(3); // Имитируем долгую обработку.
            $this->mailService->sendMessageSuccessfullyProcessedLetter($email, $text);
            $message->ack();
            echo 'Сообщение успешно обработано.' . PHP_EOL . PHP_EOL;
        } catch (Throwable $e) {
            (new LoggerFactory())->create()->error($e->getMessage());
            $message->nack();
            echo 'Ошибка при обработке сообщения!' . PHP_EOL . PHP_EOL;
        }
    }
}
