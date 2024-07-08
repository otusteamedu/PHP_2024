<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\DTO;

class ReportResponse
{
    public function __construct(public readonly string $url, public readonly string $title)
    {
    }
}
