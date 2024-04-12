<?php

declare(strict_types=1);

namespace App\Resource\News;

use App\News\Domain\Decorator\Content\ReadingTimeContentDecorator;
use App\News\Domain\Entity\News;
use App\Resource\ResourceInterface;

readonly class NewsResource implements ResourceInterface
{
    public function __construct(protected News $news)
    {

    }

    public function toArray(): array
    {
        return [
            'id' => $this->news->getId(),
            'title' => $this->news->getTitle()->value(),
            'created_at' => $this->news->getCreatedAt()->format('Y-m-d H:i:s'),
            'content' => fn() => (new ReadingTimeContentDecorator($this->news->getContent()))->getContent()->value(),
            'category' => $this->news->getCategory()->getName()->value(),
        ];
    }
}