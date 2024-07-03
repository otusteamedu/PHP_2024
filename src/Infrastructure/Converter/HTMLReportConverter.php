<?php

declare(strict_types=1);

namespace App\Infrastructure\Converter;

use App\Application\UseCase\News\Converter\ReportConverterInterface;
use App\Domain\Enum\ReportFormat;
use App\Application\UseCase\News\DTO\ReportResponse;

class HTMLReportConverter implements ReportConverterInterface
{
    public function convert(ReportResponse ...$reportLines): string
    {
        return "<ul>\n" . implode("\n", array_map(static function (ReportResponse $reportLine) {
            return "<li><a href='$reportLine->url'>{$reportLine->title}</a></li>";
        }, $reportLines)) . "\n</ul>";
    }

    public function getFormat(): ReportFormat
    {
        return ReportFormat::HTML;
    }
}
