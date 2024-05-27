<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response\DTO;

readonly class ReportDto
{
    public function __construct(
        public string $reportLink,
    ) {
    }
}
