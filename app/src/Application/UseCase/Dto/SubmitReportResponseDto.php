<?php

declare(strict_types=1);

namespace App\Application\UseCase\Dto;

class SubmitReportResponseDto
{
    public function __construct(public string $fileSrc)
    {
    }
}
