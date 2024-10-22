<?php

declare(strict_types=1);

namespace App\Application\Report;

use App\Application\Report\Dto\SubmitReportGeneratorRequestDto;
use App\Application\Report\Dto\SubmitReportGeneratorResponseDto;

interface ReportGeneratorInterface
{
    public function generate(SubmitReportGeneratorRequestDto $requestDto): SubmitReportGeneratorResponseDto;
}
