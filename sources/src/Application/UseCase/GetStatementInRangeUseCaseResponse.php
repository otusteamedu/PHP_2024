<?php

declare(strict_types=1);

namespace App\Application\UseCase;

class GetStatementInRangeUseCaseResponse
{
    public function __construct(
        public string $message,
    )
    {
    }
}