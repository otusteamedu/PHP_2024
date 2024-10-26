<?php

declare(strict_types=1);

namespace App\Application\UseCase\NewsGetListUseCase\Boundary;

use App\Domain\Entity\News;

class NewsGetResponse
{
    public function __construct(
        private int $id,
        private string $title,
        private \DateTimeImmutable $createdAt,
        private string $url,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public static function fromBoundary(News $news): self
    {
        return new self(
            $news->getId(),
            $news->getTitle()->getValue(),
            $news->getCreatedAt(),
            $news->getUrl()->getValue(),
        );
    }
}
