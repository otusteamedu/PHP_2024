<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\Youtube\Mapper;

use DateMalformedStringException;
use Valen\App\Domain\Youtube\Channel;

final class ChannelMapper
{
    /**
     * Преобразует данные из хранилища в доменную модель
     * @throws DateMalformedStringException
     */
    public function toDomain(array $data): Channel
    {
        // Приводим ключи из OpenSearch к формату, ожидаемому методом fromArray
        $mappedData = [
            'channel_id' => $data['channelId'] ?? '',
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'subscriber_count' => (int)($data['subscriberCount'] ?? 0),
            'video_count' => (int)($data['videoCount'] ?? 0),
            'published_at' => $data['publishedAt'] ?? date('c'),
        ];

        return Channel::fromArray($mappedData);
    }

    /**
     * Преобразует доменную модель в формат для хранения в OpenSearch
     */
    public function toStorage(Channel $channel): array
    {
        // Получаем данные из модели и приводим ключи к формату OpenSearch
        $channelArray = $channel->toArray();

        return [
            'channelId' => $channelArray['channel_id'],
            'title' => $channelArray['title'],
            'description' => $channelArray['description'],
            'subscriberCount' => $channelArray['subscriber_count'],
            'videoCount' => $channelArray['video_count'],
            'publishedAt' => $channelArray['published_at'],
        ];
    }
}
