<?php

declare(strict_types=1);

namespace App\Infrastructure\ReportMaker;

use App\Application\ReportMaker\ReportMakerInterface;

class HtmlReportMaker implements ReportMakerInterface
{
    public function makeReport(array $newsList): string
    {
        $content = "<ul>";
        foreach ($newsList as $news) {
            $content .= "<li><a href=\"{$news->url}\">{$news->title}</a></li>";
        }
        $content .= "<ul>";

        return $content;
    }
}