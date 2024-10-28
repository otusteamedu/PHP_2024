<?php

declare(strict_types=1);

namespace App\Infrastructure\Output;

use App\Domain\Entity\News;
use App\Domain\Strategy\NewsStrategyInterface;

class NewsPlainTextStrategy implements NewsStrategyInterface
{
    public function getText(News $news): string
    {
        return strip_tags(htmlspecialchars_decode($news->getText()->getValue()));
    }
}