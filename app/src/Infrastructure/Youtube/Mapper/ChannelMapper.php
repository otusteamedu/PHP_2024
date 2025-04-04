<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\Youtube\Mapper;

use Valen\App\Domain\Youtube\Channel;

final class ChannelMapper
{
    public function toStorage(Channel $channel): array
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
}
