<?php

declare(strict_types=1);

namespace Alogachev\Homework\Application\UseCase;

use Alogachev\Homework\Application\Exception\BankStatementNotFound;
use Alogachev\Homework\Application\UseCase\Request\GetBankStatementRequest;
use Alogachev\Homework\Application\UseCase\Response\GetBankStatementResponse;
use Alogachev\Homework\Domain\Repository\BankStatementRepositoryInterface;
use Alogachev\Homework\Domain\Repository\Query\FindBankStatementQuery;

class GetBankStatementUseCase
{
    public function __construct(
        private readonly BankStatementRepositoryInterface $statementRepository,
    ) {
    }

    public function __invoke(GetBankStatementRequest $request): GetBankStatementResponse
    {
        $bankStatement = $this->statementRepository->findById(
            new FindBankStatementQuery($request->id),
        );

        if (is_null($bankStatement)) {
            throw new BankStatementNotFound();
        }

        return new GetBankStatementResponse(
            $bankStatement->getId(),
            $bankStatement->getClientName(),
            $bankStatement->getAccountNumber(),
            $bankStatement->getStartDate()->format('Y-m-d'),
            $bankStatement->getEndDate()->format('Y-m-d'),
            $bankStatement->getStatus()->getValue(),
        );
    }
}
