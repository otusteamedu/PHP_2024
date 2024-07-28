<?php

declare(strict_types=1);

namespace App\Application\UseCase\Api\v1;

use App\Application\UseCase\Api\v1\Request\CreateTransactionReportRequest;
use App\Application\UseCase\Api\v1\Response\CreateTransactionReportResponse;
use App\Domain\Contract\QueueConnectionInterface;
use App\Domain\Contract\QueueMessageInterface;
use App\Domain\Contract\RepositoryInterface;
use App\Domain\Entity\QueueReport;
use App\Domain\Enum\QueueReport\QueueReportStatusEnum;
use App\Domain\ValueObject\BankTransaction\BankAccount;
use App\Domain\ValueObject\BankTransaction\TransactionStatus;
use App\Domain\ValueObject\BankTransaction\TransactionType;
use App\Domain\ValueObject\Datetime;
use Exception;

use function Symfony\Component\Clock\now;

final readonly class CreateTransactionReport
{
    public function __construct(
        private RepositoryInterface $queueReportRepository,
        private QueueConnectionInterface $connection,
        private QueueMessageInterface $queueMessage
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateTransactionReportRequest $request): CreateTransactionReportResponse
    {
        $dateFrom = new Datetime($request->dateFrom);
        $dateTo = new Datetime($request->dateFrom);
        $accountFrom = new BankAccount($request->accountFrom);
        $accountTo = new BankAccount($request->accountTo);
        $status = new TransactionStatus($request->transactionStatus);
        $type = new TransactionType($request->transactionType);

        $channel = $this->connection->channel();

        $uid = uniqid('queue.transaction-');

        $this->queueReportRepository->save(
            new QueueReport(
                $uid,
                QueueReportStatusEnum::AWAIT->value,
                null,
                now()->format('Y-m-d H:m'),
                now()->format('Y-m-d H:m')
            )
        );


        $channel->basic_publish($this->queueMessage->setBody(json_encode([
            'uid' => $uid,
            'dateFrom' => $dateFrom->getValue()->format('Y-m-d H:i:s'),
            'dateTo' => $dateTo->getValue()->format('Y-m-d H:i:s'),
            'accountFrom' => $accountFrom->getValue(),
            'accountTo' => $accountTo->getValue(),
            'status' => $status->getValue()->value,
            'type' => $type->getValue()->value,
        ])), '', 'transaction');

        return new CreateTransactionReportResponse($uid);
    }
}
