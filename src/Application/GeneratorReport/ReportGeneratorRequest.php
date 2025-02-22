<?php

namespace App\Application\GeneratorReport;

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

readonly class ReportGeneratorRequest
{
    public function __construct(
        public Url $url,
        public Title $title,
    ) {
    }
}
