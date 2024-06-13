<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\Dto;

use DateTimeImmutable;

class NewsDto
{
    public function __construct(
        readonly private int $id,
        readonly private DateTimeImmutable $createdAt,
        readonly private string $url,
        readonly private string $title
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
