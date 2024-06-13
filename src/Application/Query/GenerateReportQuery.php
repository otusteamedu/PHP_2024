<?php

declare(strict_types=1);

namespace App\Application\Query;

class GenerateReportQuery
{
    public function __construct(
        private readonly array $ids
    ) {}

    public function getIds(): array
    {
        return $this->ids;
    }
}
