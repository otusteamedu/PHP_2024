<?php

declare(strict_types=1);

namespace App\Application\Helper\DTO;

readonly class ReportDTO
{
    public function __construct(public string $reportUrl)
    {
    }
}
