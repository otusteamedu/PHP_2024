<?php

namespace App\Application\GeneratorReport;

readonly class ReportGeneratorResponse
{
    function __construct(
        public string $fileName,
    ) {
    }
}
