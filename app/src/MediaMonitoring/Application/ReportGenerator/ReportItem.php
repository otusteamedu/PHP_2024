<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\ReportGenerator;

final readonly class ReportItem
{
    public function __construct(
        public string $title,
        public string $url,
    ) {}
}
