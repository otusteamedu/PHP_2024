<?php

namespace App\Domain\ReportGenerator;

class ReportGeneratorResponse
{

    public function __construct(
        public readonly string $link,
    )
    {
    }
}
