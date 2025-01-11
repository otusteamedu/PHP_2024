<?php

namespace App\Application\UseCase\GetStatementUseCase;

use App\Domain\Repository\StatementRepositoryInterface;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\ValueObject\Status;
use App\Infrastructure\Entity\StatusEnum;

class GetStatementUseCase
{
    public function __construct(
        private StatementRepositoryInterface $statementRepository,
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function __invoke(GetStatementRequest $request): GetStatementResponse
    {
        $statement = $this->statementRepository->findById($request->statementId);
        $statement->setStatus(new Status(StatusEnum::Processing->value));
        $this->statementRepository->save($statement);
        $transactions = $this->transactionRepository->findForStatement(
            $statement->getAccount()->getValue(),
            $statement->getDateFrom()->getValue(),
            $statement->getDateTo()->getValue()
        );
        $statement->setTransactions($transactions);
        return new GetStatementResponse(
            $statement
        );
    }
}
