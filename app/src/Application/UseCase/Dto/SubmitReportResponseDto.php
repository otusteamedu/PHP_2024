<?php

namespace App\Application\UseCase\Dto;

class SubmitReportResponseDto
{
    public function __construct(public string $fileSrc)
    {
    }
}
