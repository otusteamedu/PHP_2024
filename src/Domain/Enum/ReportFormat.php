<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ReportFormat
{
    case HTML;
    case PlainText;
    case JSON;
    case CSV;
}
