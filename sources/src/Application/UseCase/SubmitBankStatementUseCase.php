<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Factory\BankStatementFactory;
use App\Domain\Repository\BankStatementRepositoryInterface;

readonly class SubmitBankStatementUseCase
{
    public function __construct(
        private BankStatementFactory             $factory,
        private BankStatementRepositoryInterface $repository
    )
    {
    }

    public function __invoke(SubmitBankStatementUseCaseRequest $request): SubmitBankStatementUseCaseResponse
    {
        $bankStatement = $this->factory->create(
            $request->account,
            $request->title,
            $request->date
        );

        $this->repository->save($bankStatement);

        return new SubmitBankStatementUseCaseResponse($bankStatement->getAccount());
    }
}
