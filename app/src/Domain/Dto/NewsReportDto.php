<?php

declare(strict_types=1);

namespace App\Domain\Dto;

class NewsReportDto
{
    public function __construct(public string $content, public string $extension)
    {
    }
}
