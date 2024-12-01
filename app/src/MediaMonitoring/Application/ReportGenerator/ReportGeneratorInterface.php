<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\ReportGenerator;

interface ReportGeneratorInterface
{
    public function getType(): ReportType;

    public function generate(ReportItem ...$items): string;
}
