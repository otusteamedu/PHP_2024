<?php

declare(strict_types=1);

namespace App\Application\Helper\DTO;

readonly class NewsReportDTO
{
    public function __construct(public string $url, public string $title)
    {
    }
}
