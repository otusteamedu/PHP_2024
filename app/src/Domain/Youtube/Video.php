<?php

declare(strict_types=1);

namespace Valen\App\Domain\Youtube;

use DateTime;

class Video
{
    private string $videoId;
    private string $title;
    private DateTime $publishedAt;
    private int $viewCount;
    private int $likeCount;
    private int $dislikeCount;
    private int $commentCount;
    private string $channelId;

    public function getVideoId(): string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): void
    {
        $this->videoId = $videoId;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPublishedAt(): DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTime $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function setViewCount(int $viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): void
    {
        $this->likeCount = $likeCount;
    }

    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    public function setDislikeCount(int $dislikeCount): void
    {
        $this->dislikeCount = $dislikeCount;
    }

    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    public function setCommentCount(int $commentCount): void
    {
        $this->commentCount = $commentCount;
    }

    public static function createFromArray(array $data): Video
    {
        $video = new self();

        $video->videoId = $data['videoId'];
        $video->title = $data['title'];
        $video->publishedAt = new DateTime($data['publishedAt']);
        $video->viewCount = $data['viewCount'];
        $video->likeCount = $data['likeCount'];
        $video->dislikeCount = $data['dislikeCount'];
        $video->commentCount = $data['commentCount'];
        $video->channelId = $data['channelId'];

        return $video;
    }
}
