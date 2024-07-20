<?php

declare(strict_types=1);

namespace App\Application\UseCase\Api\v1\Response;

final readonly class CreateTransactionReportResponse
{
    public function __construct(
        public string $uid
    ) {
    }
}
