<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\News\Mapper;

use Valen\App\Domain\News\Entity\News;

final class NewsMapper
{
    public function toStorage(News $channel): array
    {
        return [
            'id' => $channel->getChannelId(),
            'channelId' => $channel->getChannelId(),
            'title' => $channel->getTitle(),
            'description' => $channel->getDescription(),
            'subscriberCount' => $channel->getSubscriberCount(),
            'videoCount' => $channel->getVideoCount(),
            'publishedAt' => $channel->getPublishedAt()->format('c'),
        ];
    }

    public function toDomain(array $channel): News
    {
        return News::createFromArray($channel);
    }
}
