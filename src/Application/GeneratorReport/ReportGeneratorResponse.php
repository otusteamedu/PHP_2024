<?php

namespace App\Application\GeneratorReport;

readonly class ReportGeneratorResponse
{
    public function __construct(
        public string $fileName,
    ) {
    }
}
