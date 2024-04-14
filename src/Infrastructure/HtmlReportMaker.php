<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\ReportMakerInterface;

class HtmlReportMaker implements ReportMakerInterface
{
    public function makeReport(array $newsList): string
    {
        $content = "<ul>";
        foreach ($newsList as $news) {
            $content .= "<li><a href=\"{$news->getUrl()->getValue()}\">{$news->getTitle()->getValue()}</a></li>";
        }
        $content .= "<ul>";

        return $content;
    }
}