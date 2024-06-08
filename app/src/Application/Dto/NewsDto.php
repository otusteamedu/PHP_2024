<?php

declare(strict_types=1);

namespace App\Application\Dto;

use App\Domain\Entity\News;

class NewsDto
{
    public function __construct(
        public int $id,
        public string $url,
        public string $name,
        public string $date,
    ) {
    }

    public static function createFromNews(News $news): self
    {
        return new self(
            $news->getId(),
            (string) $news->getUrl(),
            (string) $news->getName(),
            $news->getDate()->format('Y-m-d H:i:s'),
        );
    }
}
