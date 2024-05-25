<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\Converter;

use App\Domain\Enum\ReportFormat;
use App\Domain\ValueObject\ReportLine;

interface ReportConverterInterface
{
    public function convert(ReportLine ...$reportLines): string;

    public function getFormat(): ReportFormat;
}
