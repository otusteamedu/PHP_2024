<?php

declare(strict_types=1);

namespace App\Services\News\Decorator;

class NewsItemAddTimeToReadContent implements NewsItemContentInterface
{
    public function __construct(protected NewsItemContentInterface $newsItemContent)
    {
    }

    public function getContent(): string
    {
        $content = $this->newsItemContent->getContent();
        $content .= '<div>Время чтения новости '.rand(1, 5).' мин.</div>';

        return $content;
    }
}
