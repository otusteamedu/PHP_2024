<?php

declare(strict_types=1);

namespace App\Application\ContentDownloader;

use App\Application\UseCase\Request\ContentDownloaderRequest;
use App\Application\UseCase\Response\ContentDownloaderResponse;

interface ContentDownloaderInterface
{
    public function download(ContentDownloaderRequest $request): ContentDownloaderResponse;
}