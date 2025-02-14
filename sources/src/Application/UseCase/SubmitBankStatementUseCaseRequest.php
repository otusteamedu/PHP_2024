<?php

declare(strict_types=1);

namespace App\Application\UseCase;

class SubmitBankStatementUseCaseRequest
{
    public function __construct(
        public int    $account,
        public string $title,
        public string $date
    )
    {
    }
}
