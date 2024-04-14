<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class MakeConsolidatedReportRequest
{
    public function __construct(public readonly array $ids)
    {
    }
}