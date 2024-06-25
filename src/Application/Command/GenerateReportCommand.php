<?php

declare(strict_types=1);

namespace App\Application\Command;

readonly class GenerateReportCommand
{
    public function __construct(
        private array $ids
    ) {}

    public function getIds(): array
    {
        return $this->ids;
    }
}
