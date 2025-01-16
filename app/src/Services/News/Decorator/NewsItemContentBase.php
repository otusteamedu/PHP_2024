<?php

declare(strict_types=1);

namespace App\Services\News\Decorator;

class NewsItemContentBase implements NewsItemContentInterface
{
    public function __construct(protected string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
