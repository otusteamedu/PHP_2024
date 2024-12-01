<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\ReportGenerator;

use App\MediaMonitoring\Application\ReportGenerator\ReportGeneratorInterface;
use App\MediaMonitoring\Application\ReportGenerator\ReportItem;
use App\MediaMonitoring\Application\ReportGenerator\ReportType;

final readonly class ReportTypeHtmlGenerator implements ReportGeneratorInterface
{
    public function getType(): ReportType
    {
        return ReportType::HTML;
    }

    public function generate(ReportItem ...$items): string
    {
        $html = '';

        foreach ($items as $item) {
            $html .= sprintf(
                '<li><a href="%s">%s</a></li>',
                $item->url,
                $item->title
            );
        }

        return '<ul>' . $html . '</ul>';
    }
}
