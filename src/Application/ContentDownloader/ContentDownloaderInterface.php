<?php

declare(strict_types=1);

namespace App\Application\ContentDownloader;

interface ContentDownloaderInterface
{
    public function download(string $url): string;
}