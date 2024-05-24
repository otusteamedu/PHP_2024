<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class MakeConsolidatedReportRequest
{
    public function __construct(public array $ids)
    {
    }
}