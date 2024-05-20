<?php

declare(strict_types=1);

namespace App\Application\Helper\Response;

class ReportGeneratorResponse
{
    public function __construct(
        public readonly string $filePath
    ) {}
}
