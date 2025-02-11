<?php

declare(strict_types=1);

namespace App\Application\Gateway\ReportGenerator;

readonly class ReportGeneratorResponse
{
    public function __construct(
        private string $link
    )
    {
    }

    public function getLink(): string
    {
        return $this->link;
    }
}