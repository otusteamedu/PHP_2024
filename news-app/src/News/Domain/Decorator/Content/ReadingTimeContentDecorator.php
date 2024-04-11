<?php

declare(strict_types=1);

namespace App\News\Domain\Decorator\Content;

use App\News\Domain\ValueObject\Content;

class ReadingTimeContentDecorator implements ContentDecoratorInterface
{
    const WORDS_PER_MINUTE = 200;

    public function __construct(
        protected readonly Content $content
    )
    {
    }

    public function getContent(): Content
    {
        $content = $this->content->value();
        $readingTime = $this->getReadingTime($content);

        return Content::fromString($content."<br/>".$readingTime);
    }

    private function getReadingTime(string $content): string
    {
        $words = explode(' ', $content);
        $wordsCount = count($words);
        $readingTime = ceil($wordsCount / self::WORDS_PER_MINUTE);

        return sprintf('Время чтения %s минут', $readingTime);
    }
}