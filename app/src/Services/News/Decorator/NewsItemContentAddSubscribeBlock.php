<?php

declare(strict_types=1);

namespace App\Services\News\Decorator;

class NewsItemContentAddSubscribeBlock implements NewsItemContentInterface
{
    public function __construct(protected NewsItemContentInterface $newsItemContent)
    {
    }

    public function getContent(): string
    {
        $content = $this->newsItemContent->getContent();
        $content .= '<div>Подписаться в соцсетях myspace, hi5, orcut</div>';

        return $content;
    }
}
