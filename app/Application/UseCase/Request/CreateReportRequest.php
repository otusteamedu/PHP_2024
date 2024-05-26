<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

final readonly class CreateReportRequest
{
    public function __construct(public array $ids)
    {
    }
}
