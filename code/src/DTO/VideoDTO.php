<?php

namespace SergeyShirykalov\YoutubeChannels\DTO;

class VideoDTO
{
    public function __construct(
        private string $id,
        private string $channel,
        private string $title,
        private \DateTimeImmutable $releaseDate,
        private string $likes,
        private string $dislikes,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): VideoDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): VideoDTO
    {
        $this->channel = $channel;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): VideoDTO
    {
        $this->title = $title;
        return $this;
    }

    public function getReleaseDate(): \DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeImmutable $releaseDate): VideoDTO
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getLikes(): string
    {
        return $this->likes;
    }

    public function setLikes(string $likes): VideoDTO
    {
        $this->likes = $likes;
        return $this;
    }

    public function getDislikes(): string
    {
        return $this->dislikes;
    }

    public function setDislikes(string $dislikes): VideoDTO
    {
        $this->dislikes = $dislikes;
        return $this;
    }

}