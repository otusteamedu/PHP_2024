<?php

namespace App\Application\UseCase\Console;

use App\Application\UseCase\Console\Request\GenerateTransactionReportRequest;
use App\Application\UseCase\Console\Response\GenerateTransactionReportResponse;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Exception\Validate\TransactionAccountNumberException;
use App\Domain\Exception\Validate\TransactionStatusException;
use App\Domain\Exception\Validate\TransactionTypeException;
use App\Domain\ValueObject\BankTransaction\BankAccount;
use App\Domain\ValueObject\BankTransaction\TransactionStatus;
use App\Domain\ValueObject\BankTransaction\TransactionType;
use App\Domain\ValueObject\Datetime;
use Exception;

class GenerateTransactionReport
{
    public function __construct(private readonly RepositoryInterface $repository)
    {
    }

    /**
     * @throws TransactionStatusException
     * @throws TransactionTypeException
     * @throws TransactionAccountNumberException
     * @throws Exception
     */
    public function __invoke(GenerateTransactionReportRequest $request): GenerateTransactionReportResponse
    {
        $dateFrom = new Datetime($request->dateFrom);
        $dateTo = new Datetime($request->dateFrom);
        $accountFrom = new BankAccount($request->accountFrom);
        $accountTo = new BankAccount($request->accountTo);
        $status = new TransactionStatus($request->transactionStatus);
        $type = new TransactionType($request->transactionType);

        return new GenerateTransactionReportResponse();
    }
}