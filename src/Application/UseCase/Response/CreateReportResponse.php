<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class CreateReportResponse
{
    public function __construct(
        public string $reportLink,
    ) {
    }
}
