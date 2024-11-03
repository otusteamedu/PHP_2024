<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNewsReport;

class CreateNewsReportRequest
{
    public function __construct(public readonly array $ids)
    {
    }
}
