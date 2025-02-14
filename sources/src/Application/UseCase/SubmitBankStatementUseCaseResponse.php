<?php

declare(strict_types=1);

namespace App\Application\UseCase;

readonly class SubmitBankStatementUseCaseResponse
{
    public function __construct(
        public int $accountId,
    )
    {
    }
}
