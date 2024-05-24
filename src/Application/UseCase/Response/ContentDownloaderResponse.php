<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

readonly class ContentDownloaderResponse
{
    public function __construct(public string $content)
    {
    }
}