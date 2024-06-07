<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class GenerateReportRequest
{
    public function __construct(public array $ids)
    {
    }
}
