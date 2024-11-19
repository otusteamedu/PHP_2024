<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\SubmitStatementRequest;
use App\Application\UseCase\SubmitStatementResponse;
use App\Domain\Repository\BankStatementRepositoryInterface;
use App\Domain\Factory\BankStatementFactoryInterface;
use App\Application\Gateway\QueueGatewayInterface;
use App\Application\Gateway\QueueGatewayRequest;

class GetBankStatementUseCase
{
    public function __construct(private readonly BankStatementFactoryInterface $statementFactory, private readonly BankStatementRepositoryInterface $statementRepository, private readonly QueueGatewayInterface $queueGateway)
    {
    }

    public function __invoke(SubmitStatementRequest $request): SubmitStatementResponse
    {
        $bankStatement = $this->statementFactory->create($request->account, $request->dateFrom, $request->dateTo);

        $this->statementRepository->save($bankStatement);
        $this->queueGateway->sendTask(new QueueGatewayRequest($bankStatement->getId()));

        return new SubmitStatementResponse(
            $bankStatement->getId()
        );
    }
}
