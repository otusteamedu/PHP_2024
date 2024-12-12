<?php

declare(strict_types=1);

namespace App\Services\News\Strategy;

class NewsItemPlainContent implements NewsItemContent
{
    public function getContent(string $content): string
    {
        return strip_tags($content);
    }
}
