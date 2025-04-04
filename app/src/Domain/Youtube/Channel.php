<?php

declare(strict_types=1);

namespace Valen\App\Domain\Youtube;

use DateTimeImmutable;

class Channel
{
    private ?int $id = null;
    private string $channelId;
    private string $title;
    private string $description;

    private int $subscriberCount;
    private int $videoCount;
    private DateTimeImmutable $publishedAt;

    // Реализация LazyLoad
    private array|null $video = null;

    public function __construct(private readonly VideoRepositoryInterface $videoRepository)
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setSubscriberCount(int $subscriberCount): void
    {
        $this->subscriberCount = $subscriberCount;
    }

    public function setVideoCount(int $videoCount): void
    {
        $this->videoCount = $videoCount;
    }

    public function setPublishedAt(DateTimeImmutable $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSubscriberCount(): int
    {
        return $this->subscriberCount;
    }

    public function getVideoCount(): int
    {
        return $this->videoCount;
    }

    public function getPublishedAt(): DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function getVideo(): array|null
    {
        if ($this->video === null) {
            $this->video = $this->videoRepository->findByChannelId($this->channelId);
        }

        return $this->video;
    }
}
