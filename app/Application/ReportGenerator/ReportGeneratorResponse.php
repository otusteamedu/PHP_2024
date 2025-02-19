<?php

namespace App\Application\ReportGenerator;

class ReportGeneratorResponse
{
    public function __construct(
        public readonly string $link,
    ) {
    }
}
