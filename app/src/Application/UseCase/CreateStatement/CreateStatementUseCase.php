<?php

namespace App\Application\UseCase\CreateStatement;


use App\Domain\Factory\StatementFactoryInterface;

use App\Domain\Repository\StatementRepositoryInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;


class CreateStatementUseCase
{
    public function __construct(
        private readonly StatementFactoryInterface $accountFactory,
        private readonly StatementRepositoryInterface  $accountRepository,
        private readonly ProducerInterface $producer
    )
    {
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(CreateStatementRequest $request): CreateStatementResponse
    {
        $statement = $this->accountFactory->create(
            $request->accountNumber,
            $request->dateFrom,
            $request->dateTo,
            $request->status
        );
        $this->accountRepository->save($statement);
        $this->producer->publish(
            json_encode(['statementId' => (int)$statement->getId()], JSON_THROW_ON_ERROR, 512)
        );
        return new CreateStatementResponse(
            $statement->getId()
        );
    }
}