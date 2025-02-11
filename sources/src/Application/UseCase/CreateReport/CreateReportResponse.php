<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateReport;

readonly class CreateReportResponse
{
    public function __construct(
        private string $link,
    )
    {
    }

    public function getLink(): string
    {
        return $this->link;
    }
}