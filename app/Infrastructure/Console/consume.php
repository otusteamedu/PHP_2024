<?php

use App\Domain\Entity\QueueReport;
use App\Domain\Enum\QueueReport\QueueReportStatusEnum;
use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Repository\QueueReportRepository;
use App\Infrastructure\Repository\TransactionRepository;
use App\Infrastructure\Service\ReportFileCreator;
use PhpAmqpLib\Connection\AMQPStreamConnection;

require __DIR__ . '/../Support/helpers.php';
require __DIR__ . '/../../../vendor/autoload.php';

ini_set('memory_limit', '8024M');

$callback = function ($msg) {
    $message = json_decode($msg->body, 512, JSON_THROW_ON_ERROR);
    $uid = $message['uid'];
    $accountFrom = $message['accountFrom'];

    $QueueReportsRepository = new QueueReportRepository(DatabaseConnection::getInstance());
    $transactionsRepository = new TransactionRepository(DatabaseConnection::getInstance());

    /**
     * @var $queueReport QueueReport
     */
    $queueReport = $QueueReportsRepository->findBy('uid', $uid)[0];
    $transactions = $transactionsRepository->findBy('account_from', $accountFrom);

    $creator = new ReportFileCreator();
    $fileName = time() . '.html';
    $creator->createReportFile($fileName, $transactions);

    if ($queueReport) {
        $queueReport->setStatus(QueueReportStatusEnum::SUCCESS->value);
        $queueReport->setUpdatedAt(date('Y-m-d H:m'));
        $queueReport->setFilePath(__DIR__ . DIRECTORY_SEPARATOR . $fileName);
        $QueueReportsRepository->update($queueReport);
    }

    echo ' [x] Received ', $message['status'], "\n";
};

try {
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
    $channel = $connection->channel();
    $channel->queue_declare('transaction', false, false, false, false);
    $channel->basic_consume(
        'transaction',
        '',
        false,
        true,
        false,
        false,
        $callback
    );
    $channel->consume();
} catch (Exception $e) {
    echo $e->getMessage();
}