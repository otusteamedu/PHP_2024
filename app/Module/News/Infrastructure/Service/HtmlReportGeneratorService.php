<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Service;

use Illuminate\Support\Facades\File;
use Module\News\Application\Service\Interface\ReportGeneratorServiceInterface;
use Module\News\Domain\Entity\NewsCollection;
use Module\News\Domain\ValueObject\Url;

final class HtmlReportGeneratorService implements ReportGeneratorServiceInterface
{
    public function generate(NewsCollection $newsCollection): Url
    {
        $path = $this->getStoragePath();
        $content = $this->prepareContent($newsCollection);
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

    private function prepareContent(NewsCollection $newsCollection): string
    {
        $body = ['<ul>'];
        foreach ($newsCollection->all() as $news) {
            $url = $news->getUrl()->getValue();
            $title = $news->getTitle()->getValue();
            $body[] = "<li><a href='$url'>$title</a></li>";
        }
        $body[] = '</ul>';

        return implode('', $body);
    }
}
