<?php

namespace SergeyShirykalov\YoutubeChannels\Entity;

readonly class Video
{
    public function __construct(
        private string             $channel,
        private string             $title,
        private \DateTimeImmutable $date,
        private int                $likes,
        private int                $dislikes,
    )
    {
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

}
