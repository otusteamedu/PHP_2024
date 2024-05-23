<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Service;

use Illuminate\Support\Facades\File;
use Module\News\Application\Service\Dto\NewsDto;
use Module\News\Application\Service\Interface\ReportGeneratorServiceInterface;
use Module\News\Domain\ValueObject\Url;

final class HtmlReportGeneratorService implements ReportGeneratorServiceInterface
{
    public function generate(NewsDto ...$newsDtoList): Url
    {
        $path = $this->getStoragePath();
        $content = $this->prepareContent(...$newsDtoList);
        file_put_contents($path, $content);

        return new Url(asset($path));
    }

    private function getStoragePath(): string
    {
        $basePath = config('report.path');
        $storagePath = storage_path($basePath);
        if (!file_exists($storagePath)) {
            File::makeDirectory($storagePath);
        }
        $name = time() . '_report.html';
        return "$storagePath/$name";
    }

    private function prepareContent(NewsDto ...$newsDtoList): string
    {
        $body = '<ul>';
        foreach ($newsDtoList as $news) {
            $body .= "<li><a href='{$news->url}'>{$news->title}</a></li>";
        }
        return $body . '</ul>';
    }
}
