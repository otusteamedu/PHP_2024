<?php

declare(strict_types=1);

namespace App\Application\Handler\Response;

class GenerateReportResponse
{
    public function __construct(
        public readonly string $link
    ) {}
}
