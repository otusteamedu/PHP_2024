<?php

declare(strict_types=1);

namespace Valen\App\Infrastructure\Youtube\Mapper;

use Valen\App\Domain\Youtube\Video;

final class VideoMapper
{
    public function toStorage(Video $video): array
    {
        return [
            'id' => $video->getId(),
            'videoId' => $video->getVideoId(),
            'channelId' => $video->getChannelId(),
            'title' => $video->getTitle(),
            'publishedAt' => $video->getPublishedAt()->format('c'),
            'viewCount' => $video->getViewCount(),
            'likeCount' => $video->getLikeCount(),
            'dislikeCount' => $video->getDislikeCount(),
            'commentCount' => $video->getCommentCount(),
        ];
    }
}
