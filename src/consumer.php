<?php

declare(strict_types=1);

use SergeyShirykalov\HomeworkRabbit\Application\UseCase\Consume\ConsumeUseCase;
use SergeyShirykalov\HomeworkRabbit\Application\UseCase\Consume\ReceivedMessage;
use SergeyShirykalov\HomeworkRabbit\Infrastructure\Consumer\Consumer;
use SergeyShirykalov\HomeworkRabbit\Infrastructure\EmailNotification\EmailNotification;
use SergeyShirykalov\HomeworkRabbit\Infrastructure\RabbitClient;

require __DIR__ . '/../vendor/autoload.php';

// Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$rabbitClient = new RabbitClient($_ENV['RABBIT_QUEUE_NAME']);
$rabbitHandler = new Consumer($rabbitClient);
$notificationHandler = new EmailNotification();
$consumeUseCase = new ConsumeUseCase($rabbitHandler, $notificationHandler);

$callback = function (ReceivedMessage $msg) {
    print('New message: User name: ' . $msg->getBody() . '; ' . 'email: ' . $msg->getBody() . '; ' . 'body: ' . $msg->getBody() . '; ' .PHP_EOL);
};

($consumeUseCase)($callback);
