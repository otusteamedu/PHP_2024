<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Domain\Enum;

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
