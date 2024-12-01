<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\ReportGenerator;

enum ReportType: string
{
    case HTML = 'html';

    public function getExtension(): string
    {
        return match ($this) {
            self::HTML => 'html',
        };
    }
}
