<?php

declare(strict_types=1);

namespace Valen\App\Domain\Youtube;

use DateTime;

class Channel
{
    private ?int $id = null;
    private string $channelId;
    private string $title;
    private string $description;

    private int $subscriberCount;
    private int $videoCount;
    private DateTime $publishedAt;

    public function __construct()
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

    public function setPublishedAt(DateTime $dataTime): void
    {
        $this->publishedAt = $dataTime;
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

    public function getPublishedAt(): DateTime
    {
        return $this->publishedAt;
    }

    public static function createFromArray(array $data): Channel
    {
        $channel = new self();
        $channel->id = $data['id'] ?? null;
        $channel->channelId = $data['channelId'];
        $channel->title = $data['title'];
        $channel->description = $data['description'];
        $channel->subscriberCount = $data['subscriberCount'];
        $channel->videoCount = $data['videoCount'];
        $channel->publishedAt = new DateTime($data['publishedAt']);

        return $channel;
    }
}
