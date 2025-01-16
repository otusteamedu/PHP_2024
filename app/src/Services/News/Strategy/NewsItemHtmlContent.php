<?php

declare(strict_types=1);

namespace App\Services\News\Strategy;

use App\Services\News\Decorator\NewsItemContentAddSubscribeBlock;
use App\Services\News\Decorator\NewsItemContentAddTimeToRead;
use App\Services\News\Decorator\NewsItemContentBase;

class NewsItemHtmlContent implements NewsItemContentInterface
{
    public function getContent(string $content): string
    {
        $newsItemContent = new NewsItemContentAddSubscribeBlock(
            new NewsItemContentAddTimeToRead(
                new NewsItemContentBase($content)
            )
        );

        return $newsItemContent->getContent();
    }
}
