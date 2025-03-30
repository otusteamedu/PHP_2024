<?php

declare(strict_types=1);

namespace Valen\App\Domain\YoutubeAnalyze;

use DateMalformedStringException;
use DateTimeImmutable;

readonly class Video
{
    public function __construct(
        public string $videoId,
        public string $channelId,
        public string $title,
        public DateTimeImmutable $publishedAt,
        public int $viewCount,
        public int $likeCount,
        public int $dislikeCount,
        public int $commentCount,
    ) {
    }

    /**
     * Создает объект Video из массива данных
     * @throws DateMalformedStringException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            videoId: $data['video_id'],
            channelId: $data['channel_id'],
            title: $data['title'],
            publishedAt: new DateTimeImmutable($data['published_at']),
            viewCount: (int)$data['view_count'],
            likeCount: (int)$data['like_count'],
            dislikeCount: (int)$data['dislike_count'],
            commentCount: (int)$data['comment_count'],
        );
    }

    /**
     * Преобразует объект в массив для сохранения в OpenSearch
     */
    public function toArray(): array
    {
        return [
            'video_id' => $this->videoId,
            'channel_id' => $this->channelId,
            'title' => $this->title,
            'published_at' => $this->publishedAt->format('c'),
            'view_count' => $this->viewCount,
            'like_count' => $this->likeCount,
            'dislike_count' => $this->dislikeCount,
            'comment_count' => $this->commentCount,
        ];
    }
}
