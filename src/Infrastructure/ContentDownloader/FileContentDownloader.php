<?php

declare(strict_types=1);

namespace App\Infrastructure\ContentDownloader;

use App\Application\ContentDownloader\ContentDownloaderInterface;
use App\Domain\Exception\DomainException;

class FileContentDownloader implements ContentDownloaderInterface
{
    public function download(string $url): string
    {
        $content = file_get_contents($url);
        if (false === $content) {
            throw new DomainException('Unable to download content');
        }
        return $content;
    }
}