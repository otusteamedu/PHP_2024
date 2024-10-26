<?php

declare(strict_types=1);

namespace App\Infrastructure\Output;

use App\Domain\Entity\News;
use App\Domain\Output\NewsPrepareTextInterface;
use App\Domain\ValueObject\Text;

class PlainTextNewsPrepareText implements NewsPrepareTextInterface
{
    public function prepareText(News $news): string
    {
        return strip_tags(htmlspecialchars_decode($news->getText()->getValue()));
    }
}