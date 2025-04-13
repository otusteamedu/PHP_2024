<?php

declare(strict_types=1);

namespace Valen\App\Domain\Youtube;

use DateTime;

class Channel
{
    private string $channelId;
    private string $title;
    private string $description;

    private int $subscriberCount;
    private int $videoCount;
    private DateTime $publishedAt;
    private ?array $videos = null;
    private ?VideoRepositoryInterface $videoRepository = null;

    public function __construct()
    {
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

    public function setVideoRepository(VideoRepositoryInterface $videoRepository): void
    {
        $this->videoRepository = $videoRepository;
    }

    public function getVideos(): array
    {
        if ($this->videos === null) {
            if ($this->videoRepository === null) {
                throw new \RuntimeException('Video repository is not set');
            }
            return $this->videos = $this->videoRepository->findByChannelId($this->channelId);
        }
        return $this->videos;
    }

    public static function createFromArray(array $data): Channel
    {
        $channel = new self();
        $channel->channelId = $data['channelId'];
        $channel->title = $data['title'];
        $channel->description = $data['description'];
        $channel->subscriberCount = $data['subscriberCount'];
        $channel->videoCount = $data['videoCount'];
        $channel->publishedAt = new DateTime($data['publishedAt']);

        return $channel;
    }
}
