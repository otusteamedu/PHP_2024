<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ReportFormat: string
{
    case HTML = 'html';
    case PlainText = 'text';
    case JSON = 'json';
    case CSV = 'csv';
}
