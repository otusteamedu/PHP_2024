<?php

namespace App\Infrastructure\Console\Callback;

use App\Application\Exception\ReportNotCreatedException;
use App\Domain\Contract\ConsumerCallbackInterface;
use App\Domain\Entity\QueueReport;
use App\Domain\Enum\QueueReport\QueueReportStatusEnum;
use App\Infrastructure\Database\DatabaseConnection;
use App\Infrastructure\Repository\QueueReportRepository;
use App\Infrastructure\Repository\TransactionRepository;
use App\Infrastructure\Service\ReportFileCreator;
use Exception;
use ReflectionException;

class TransactionReportCallback implements ConsumerCallbackInterface
{
    private function getMessage($msg): array
    {
        return json_decode($msg->body, 512, JSON_THROW_ON_ERROR);
    }

    //TODO вынести на слой Application

    /**
     * @throws ReflectionException
     * @throws ReportNotCreatedException
     * @throws Exception
     */
    public function __invoke($msg): void
    {
        $message = $this->getMessage($msg);

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
    }
}