<?php

namespace App\Infrastructure\ReportGenerator;

use App\Application\ReportGenerator\ReportGeneratorInterface;
use App\Application\ReportGenerator\ReportGeneratorRequest;
use App\Application\ReportGenerator\ReportGeneratorResponse;
use Illuminate\Support\Facades\Storage;

class InFileSummaryGenerator implements ReportGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function generate(ReportGeneratorRequest $request): ReportGeneratorResponse
    {
        $content = '<html><head><meta charset="utf-8"><title>Summary</title></head><body><ul>';
        foreach ($request->newsDto as $item) {
            $content .= '<li><a href="'
                . $item->url . '">'
                . $item->title . '</li>';
        }
        $content .= '</ul></body></html>';

        Storage::disk('public')->put('report.html', $content);
        return new ReportGeneratorResponse(Storage::disk('public')->url('/report.html'));
    }
}
