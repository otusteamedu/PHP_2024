<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Decorator;

class ReadingTimeInterface implements NewsInterface
{
    public function __construct(private NewsInterface $newsDecorator)
    {
    }

    public function printNews()
    {
        $news = $this->newsDecorator->printNews();
        $readingTime = round(strlen($news['text']) / 1500);

        $response = array("ReadingTime" => $readingTime);
        return array_merge($response, $this->newsDecorator->printNews());
    }
}
