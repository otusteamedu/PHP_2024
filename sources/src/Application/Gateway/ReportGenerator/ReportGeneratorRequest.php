<?php

declare(strict_types=1);

namespace App\Application\Gateway\ReportGenerator;

readonly class ReportGeneratorRequest
{
    public function __construct(
        private array $news
    )
    {
    }

    public function getNews(): array
    {
        return $this->news;
    }
}