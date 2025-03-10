<?php

declare(strict_types=1);

ini_set('error_reporting', E_ERROR);

use App\Application\Services\QueueService;
use App\Application\Services\ReportService;
use App\Infrastructure\AmqpClient;
use App\Infrastructure\Drivers\Queues\AmqpDriver;
use App\Infrastructure\MailClient;
use App\Infrastructure\Services\MailService;
use PhpAmqpLib\Message\AMQPMessage;

require __DIR__ . '/../../../vendor/autoload.php';

$config = require __DIR__ . '/../../../app/Infrastructure/config/config.php';

$rabbitClient = new AmqpClient($config['rabbitmq']);
$rabbitDriver = new AmqpDriver($rabbitClient);
$queueService = new QueueService($rabbitDriver);

$mailClient = new MailClient($config['mail']);
$mailService = new MailService($mailClient->getMailer());

$callback = function (AMQPMessage $msg) use ($mailService) {
    echo " [x] Received ", $msg->body, "\n";

    // Имитация времени обработки
    sleep(5);
    $dataArr = json_decode($msg->body, true);
    $reportObj = (new ReportService())
        ->setDateFrom($dataArr['dateFrom'])
        ->setDateTo($dataArr['dateTo'])
        ->create();

    $reportTitle = $reportObj->getTitle();
    $reportBody = $reportObj->getBody();
    $report = $reportObj->getFull();

    echo " [x] Processed with data:\n$report\n";

    // Подтверждаем обработку сообщения
    $msg->ack();

    // Отправка письма
    $mailService->send('recipient@example.com', 'noreply@example.com', $reportTitle, $reportBody);
    echo " [x] Email sent with subject: $reportTitle\n";
};

try {
    $queueService->receiveMessage($callback);
} catch (ErrorException $e) {
    echo $e->getMessage();
}