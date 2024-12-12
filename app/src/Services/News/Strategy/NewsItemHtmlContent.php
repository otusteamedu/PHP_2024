<?php

declare(strict_types=1);

namespace App\Services\News\Strategy;

use App\Services\News\Decorator\NewsItemAddTimeToReadContent;
use App\Services\News\Decorator\NewsItemContentAddSubscribeBlock;
use App\Services\News\Decorator\NewsItemContentBase;

class NewsItemHtmlContent implements NewsItemContent
{
    public function getContent(string $content): string
    {
        $newsItemContent = new NewsItemContentBase($content);
        $newsItemContent = new NewsItemAddTimeToReadContent($newsItemContent);
        $newsItemContent = new NewsItemContentAddSubscribeBlock($newsItemContent);

        return $newsItemContent->getContent();
    }
}
