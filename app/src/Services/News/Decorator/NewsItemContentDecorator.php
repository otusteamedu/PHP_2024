<?php

declare(strict_types=1);

namespace App\Services\News\Decorator;

abstract class NewsItemContentDecorator implements NewsItemContentInterface
{
    public function __construct(protected NewsItemContentInterface $newsItemContent)
    {
    }
}
