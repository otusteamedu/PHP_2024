<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Application\UseCase\Response\DTO\ReportDto;

readonly class CreateReportResponse
{
    public function __construct(
        public ReportDto $report,
    ) {
    }
}
