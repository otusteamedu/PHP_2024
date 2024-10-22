<?php

declare(strict_types=1);

namespace App\Application\Report\Dto;

class SubmitReportGeneratorResponseDto
{
    public function __construct(public string $fileSrc)
    {
    }
}
