<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateReport;

readonly class CreateReportRequest
{
    public function __construct(
        private array $ids,
    )
    {
    }

    public function getIds(): array
    {
        return $this->ids;
    }
}