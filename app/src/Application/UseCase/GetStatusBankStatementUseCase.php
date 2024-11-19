<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\GetStatusStatementRequest;
use App\Application\UseCase\GetStatusStatementResponse;
use App\Domain\Repository\BankStatementRepositoryInterface;

class GetStatusBankStatementUseCase
{
    public function __construct(private readonly BankStatementRepositoryInterface $statementRepository)
    {
    }

    public function __invoke(GetStatusStatementRequest $request): GetStatusStatementResponse
    {
        $result = $this->statementRepository->findById($request->id);
        return new GetStatusStatementResponse($result);
    }
}
