<?php

declare(strict_types=1);

namespace App\Application\UseCase\Console;

use App\Application\UseCase\Console\Request\GenerateTransactionReportRequest;
use App\Application\UseCase\Console\Response\GenerateTransactionReportResponse;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Exception\QueueNotFoundException;
use App\Domain\Exception\Validate\TransactionAccountNumberException;
use App\Domain\Exception\Validate\TransactionStatusException;
use App\Domain\Exception\Validate\TransactionTypeException;
use Exception;

readonly class GenerateTransactionReport
{
    public function __construct(
        private RepositoryInterface $queueRepository,
        private RepositoryInterface $transactionRepository,
    ) {
    }

    /**
     * @throws TransactionStatusException
     * @throws TransactionTypeException
     * @throws TransactionAccountNumberException
     * @throws Exception
     */
    public function __invoke(GenerateTransactionReportRequest $request): GenerateTransactionReportResponse
    {
        $uid = $request->message['uid'];

        $queueReport = $this->queueRepository->findBy('uid', $uid)[0];

        if (!$queueReport) {
            throw new QueueNotFoundException();
        }

        $queueReport->setStatus($request->transactionStatus->value);
        $queueReport->setUpdatedAt($request->updatedAt);
        $queueReport->setFilePath($request->filePath);

        $this->queueRepository->update($queueReport);

        $accountFrom = $request->message['accountFrom'];
        $transactions = $this->transactionRepository->findBy('account_from', $accountFrom);

        return new GenerateTransactionReportResponse($transactions);
    }
}
