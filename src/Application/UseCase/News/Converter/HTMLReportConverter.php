<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\Converter;

use App\Domain\ValueObject\ReportLine;

class HTMLReportConverter implements ReportConverterInterface
{
    public function convert(ReportLine ...$reportLines): string
    {
        return "<ul>\n" . implode("\n", array_map(static function (ReportLine $reportLine) {
            return "<li><a href='$reportLine->url'>{$reportLine->title}</a></li>";
        }, $reportLines)) . "\n</ul>";
    }

    public function fileExtension(): string
    {
        return 'html';
    }
}
