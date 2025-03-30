<?php

namespace SergeyShirykalov\YoutubeChannels\DTO;

class VideoAddRequest
{
    public function __construct(
        private string $channel,
        private string $title,
        private \DateTimeImmutable $releaseDate,
        private string $likes,
        private string $dislikes,
    )
    {
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): VideoAddRequest
    {
        $this->channel = $channel;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): VideoAddRequest
    {
        $this->title = $title;
        return $this;
    }

    public function getReleaseDate(): \DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeImmutable $releaseDate): VideoAddRequest
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getLikes(): string
    {
        return $this->likes;
    }

    public function setLikes(string $likes): VideoAddRequest
    {
        $this->likes = $likes;
        return $this;
    }

    public function getDislikes(): string
    {
        return $this->dislikes;
    }

    public function setDislikes(string $dislikes): VideoAddRequest
    {
        $this->dislikes = $dislikes;
        return $this;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['channel'],
            $data['title'],
            new \DateTimeImmutable($data['release_date'] ?? 0),
            $data['likes'] ?? 0,
            $data['dislikes'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'channel' => $this->channel,
            'title' => $this->title,
            'release_date' => $this->releaseDate->format(\DateTime::ATOM),
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
        ];
    }
}