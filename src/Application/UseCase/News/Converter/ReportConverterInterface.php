<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\Converter;

use App\Domain\Enum\ReportFormat;
use App\Application\UseCase\News\DTO\ReportResponse;

interface ReportConverterInterface
{
    public function convert(ReportResponse ...$reportLines): string;

    public function getFormat(): ReportFormat;
}
