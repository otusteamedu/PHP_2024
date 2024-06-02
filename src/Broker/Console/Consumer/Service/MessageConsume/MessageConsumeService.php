<?php

declare(strict_types=1);

namespace AlexanderGladkov\Broker\Console\Consumer\Service\MessageConsume;

use AlexanderGladkov\Broker\Config\Config;
use AlexanderGladkov\Broker\Service\Logger\LoggerFactory;
use AlexanderGladkov\Broker\RabbitMQ\ConnectionSettings;
use AlexanderGladkov\Broker\RabbitMQ\ExchangeParams;
use AlexanderGladkov\Broker\RabbitMQ\QueueParams;
use AlexanderGladkov\Broker\RabbitMQ\RabbitMQConsumer;
use AlexanderGladkov\Broker\Service\Mail\MailService;
use PhpAmqpLib\Message\AMQPMessage;
use Exception;

class MessageConsumeService
{
    private RabbitMQConsumer $consumer;
    private MailService $mailService;

    public function __construct(Config $config)
    {
        $connectionSettings = new ConnectionSettings(
            $config->getRabbitMQHost(),
            $config->getRabbitMQPort(),
            $config->getRabbitMQUser(),
            $config->getRabbitMQPassword()
        );

        $exchangeParams = new ExchangeParams($config->getExchangeName(), $config->getExchangeType());
        $queueParams = new QueueParams('Main');
        $this->consumer = new RabbitMQConsumer($connectionSettings, $exchangeParams, $queueParams);
        $this->mailService = new MailService($config->getGMailTransportDsn());
    }

    public function startConsume(): void
    {
        echo 'Ожидание сообщений...' . PHP_EOL . PHP_EOL;
        $this->consumer->consume(function(AMQPMessage $message) {
            $this->processMessage($message);
        });
    }

    private function processMessage(AMQPMessage $message)
    {
        $decodedBody = json_decode($message->getBody(), true);
        $email = $decodedBody['email'];
        $text = $decodedBody['text'];

        try {
            echo 'Обработка сообщения...' . PHP_EOL;
            echo $text . PHP_EOL;
            sleep(3); // Имитируем долгую обработку.
            $this->mailService->sendMessageSuccessfullyProcessedLetter($email, $text);
            $message->ack();
            echo 'Сообщение успешно обработано.' . PHP_EOL . PHP_EOL;
        } catch (Exception $e) {
            (new LoggerFactory())->create()->error($e->getMessage());
            $message->nack(false);
            echo 'Ошибка при обработке сообщения!' . PHP_EOL . PHP_EOL;
        }
    }
}
