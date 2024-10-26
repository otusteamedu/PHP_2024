<?php

declare(strict_types=1);

namespace App\Infrastructure\Output;

use App\Domain\Entity\News;
use App\Domain\Output\NewsPrepareTextInterface;
use App\Domain\ValueObject\Text;

class HtmlNewsPrepareText implements NewsPrepareTextInterface
{
    public function prepareText(News $news): string
    {
        return htmlspecialchars_decode($news->getText()->getValue());
    }
}