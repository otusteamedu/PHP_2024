<?php

declare(strict_types=1);

namespace App\Application\Report;

use DateTimeImmutable;

class ReportItem
{
    public function __construct(
        public readonly string $url,
        public readonly string $title,
        public readonly DateTimeImmutable $exportDate
    )
    {
    }
}
