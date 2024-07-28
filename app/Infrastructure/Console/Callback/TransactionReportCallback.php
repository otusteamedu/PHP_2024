<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Callback;

use App\Application\Exception\ReportNotCreatedException;
use App\Application\UseCase\Console\GenerateTransactionReport;
use App\Application\UseCase\Console\Request\GenerateTransactionReportRequest;
use App\Domain\Enum\QueueReport\QueueReportStatusEnum;
use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Repository\QueueReportRepository;
use App\Infrastructure\Repository\TransactionRepository;
use App\Infrastructure\Service\ReportFileCreator;
use Exception;

class TransactionReportCallback
{
    private function getMessage($msg): array
    {
        return json_decode($msg->body, true, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws ReportNotCreatedException
     * @throws Exception
     */
    public function __invoke($msg): void
    {
        $message = $this->getMessage($msg);

        $fileName = time() . '.html';

        $generateReportRequest = new GenerateTransactionReportRequest(
            QueueReportStatusEnum::SUCCESS,
            date('Y-m-d H:m'),
            __DIR__ . DIRECTORY_SEPARATOR . $fileName,
            $message
        );

        $generateReport = new GenerateTransactionReport(
            new QueueReportRepository(DatabaseConnection::getInstance()),
            new TransactionRepository(DatabaseConnection::getInstance())
        );

        $generateReportResponse = $generateReport($generateReportRequest);

        $creator = new ReportFileCreator();

        $creator->createReportFile(
            $fileName,
            $generateReportResponse->transactions
        );

        echo "[x] Received \n uid: {$message['uid']} \n status: {$message['status']} \n Уведомление отправлено на E-mail \n\n";
    }
}
