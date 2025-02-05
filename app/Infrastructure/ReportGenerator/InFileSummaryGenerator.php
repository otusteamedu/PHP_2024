<?php

namespace App\Infrastructure\ReportGenerator;

use App\Domain\ReportGenerator\ReportGeneratorInterface;
use App\Domain\ReportGenerator\ReportGeneratorResponse;
use Illuminate\Support\Facades\Storage;

class InFileSummaryGenerator implements ReportGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function generate(array $news): ReportGeneratorResponse
    {
        $content = '<html><head><meta charset="utf-8"><title>Summary</title></head><body><ul>';
        foreach ($news as $item) {
            $content .= '<li><a href="'
                . $item->getUrl()->getValue() . '">'
                . $item->getTitle()->getValue() . '</li>';
        }
        $content .= '</ul></body></html>';

        Storage::disk('public')->put('report.html', $content);
        return new ReportGeneratorResponse(Storage::disk('public')->url('/report.html'));
    }
}
