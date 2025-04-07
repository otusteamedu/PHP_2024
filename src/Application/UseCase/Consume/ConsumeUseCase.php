<?php

namespace SergeyShirykalov\HomeworkRabbit\Application\UseCase\Consume;

use PhpAmqpLib\Message\AMQPMessage;
use SergeyShirykalov\HomeworkRabbit\Application\AsyncHandler\BankRequest;
use SergeyShirykalov\HomeworkRabbit\Application\Consumer\ConsumerInterface;
use SergeyShirykalov\HomeworkRabbit\Application\UserNotification\UserNotification;
use SergeyShirykalov\HomeworkRabbit\Application\UserNotification\UserNotificationInterface;

readonly class ConsumeUseCase
{
    public function __construct(
        private ConsumerInterface $consumer,
        private UserNotificationInterface   $userNotification,
    )
    {
    }

    public function __invoke(callable $callback): void
    {
        // создаем обертку для переданного коллбэка с отправкой уведомления
        $callbackWithNotify = function (AMQPMessage $msg) use ($callback) {
            $decodedMessage = json_decode($msg->getBody(), true);
            $receivedMessage = new ReceivedMessage(
                $decodedMessage['userName'],
                $decodedMessage['email'],
                $decodedMessage['body'],
            );

            // Отправим уведомление
            $this->userNotification->sendNotification(new UserNotification($receivedMessage->getEmail(), $receivedMessage->getBody()));

            // Вызов переданного коллбэка, передаем в него сразу полученный объект сообщения
            $callback($receivedMessage);
        };

        // запускаем консьюмер
        $this->consumer->listenToQueue($callbackWithNotify);
    }

}