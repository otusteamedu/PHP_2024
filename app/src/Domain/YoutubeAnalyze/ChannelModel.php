<?php

declare(strict_types=1);

namespace Domain\YoutubeAnalyze;

use DateMalformedStringException;
use DateTimeImmutable;

readonly class Channel
{
    public function __construct(
        public string $channelId,
        public string $title,
        public string $description,
        public int $subscriberCount,
        public int $videoCount,
        public DateTimeImmutable $publishedAt,
    ) {
    }

    /**
     * Создает объект Channel из массива данных
     * @throws DateMalformedStringException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            channelId: $data['channel_id'],
            title: $data['title'],
            description: $data['description'],
            subscriberCount: (int)$data['subscriber_count'],
            videoCount: (int)$data['video_count'],
            publishedAt: new DateTimeImmutable($data['published_at']),
        );
    }

    /**
     * Преобразует объект в массив для сохранения в OpenSearch
     */
    public function toArray(): array
    {
        return [
            'channel_id' => $this->channelId,
            'title' => $this->title,
            'description' => $this->description,
            'subscriber_count' => $this->subscriberCount,
            'video_count' => $this->videoCount,
            'published_at' => $this->publishedAt->format('c'),
        ];
    }
}
