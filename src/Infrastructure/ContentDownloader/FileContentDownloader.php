<?php

declare(strict_types=1);

namespace App\Infrastructure\ContentDownloader;

use App\Application\ContentDownloader\ContentDownloaderInterface;
use App\Application\UseCase\Request\ContentDownloaderRequest;
use App\Application\UseCase\Response\ContentDownloaderResponse;
use App\Domain\Exception\DomainException;

class FileContentDownloader implements ContentDownloaderInterface
{
    public function download(ContentDownloaderRequest $request): ContentDownloaderResponse
    {
        $content = file_get_contents($request->url);
        if (false === $content) {
            throw new DomainException('Unable to download content');
        }
        return new ContentDownloaderResponse($content);
    }
}