<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\Youtube\Mapper;

use DateMalformedStringException;
use Valen\App\Domain\Youtube\Video;

final class VideoMapper
{
    /**
     * Преобразует данные из хранилища в доменную модель
     * @throws DateMalformedStringException
     */
    public function toDomain(array $data): Video
    {
        // Приводим ключи из OpenSearch к формату, ожидаемому методом fromArray
        $mappedData = [
            'video_id' => $data['videoId'] ?? '',
            'channel_id' => $data['channelId'] ?? '',
            'title' => $data['title'] ?? '',
            'published_at' => $data['publishedAt'] ?? date('c'),
            'view_count' => (int)($data['viewCount'] ?? 0),
            'like_count' => (int)($data['likeCount'] ?? 0),
            'dislike_count' => (int)($data['dislikeCount'] ?? 0),
            'comment_count' => (int)($data['commentCount'] ?? 0),
        ];

        return Video::fromArray($mappedData);
    }

    /**
     * Преобразует доменную модель в формат для хранения в OpenSearch
     */
    public function toStorage(Video $video): array
    {
        // Получаем данные из модели и приводим ключи к формату OpenSearch
        $videoArray = $video->toArray();

        return [
            'videoId' => $videoArray['video_id'],
            'channelId' => $videoArray['channel_id'],
            'title' => $videoArray['title'],
            'publishedAt' => $videoArray['published_at'],
            'viewCount' => $videoArray['view_count'],
            'likeCount' => $videoArray['like_count'],
            'dislikeCount' => $videoArray['dislike_count'],
            'commentCount' => $videoArray['comment_count'],
        ];
    }
}
