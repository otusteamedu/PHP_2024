<?php

declare(strict_types=1);

namespace App\Infrastructure\ReportMaker;

use App\Application\ReportMaker\ReportMakerInterface;
use App\Domain\Exception\DomainException;
use App\Infrastructure\StaticFileStorage\StaticFileStorageInterface;

class HtmlReportMaker implements ReportMakerInterface
{
    public function __construct(readonly private StaticFileStorageInterface $fileStorage)
    {
    }

    public function makeReport(array $newsList): string
    {
        $content = "<ul>";
        foreach ($newsList as $news) {
            $content .= "<li><a href=\"{$news->url}\">{$news->title}</a></li>";
        }
        $content .= "<ul>";

        $filePath = $this->fileStorage->saveReportFile($content);
        if (empty($filePath)) {
            throw new DomainException('Could not save file');
        }

        return $filePath;
    }
}