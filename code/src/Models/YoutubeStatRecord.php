<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw10\Models;

class YoutubeStatRecord
{
    private ?string $id = null;
    private ?string $channelTitle = null;
    private ?string $channelUrl = null;
    private ?string $author = null;
    private ?string $videoTitle = null;
    private ?string $videoUrl = null;
    private ?int $views = null;
    private ?string $category = null;
    private ?int $likes = null;
    private ?int $dislikes = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getChannelTitle(): ?string
    {
        return $this->channelTitle;
    }

    public function setChannelTitle(?string $channelTitle): void
    {
        $this->channelTitle = $channelTitle;
    }

    public function getChannelUrl(): ?string
    {
        return $this->channelUrl;
    }

    public function setChannelUrl(?string $channelUrl): void
    {
        $this->channelUrl = $channelUrl;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getVideoTitle(): ?string
    {
        return $this->videoTitle;
    }

    public function setVideoTitle(?string $videoTitle): void
    {
        $this->videoTitle = $videoTitle;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): void
    {
        $this->videoUrl = $videoUrl;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): void
    {
        $this->views = $views;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): void
    {
        $this->likes = $likes;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(?int $dislikes): void
    {
        $this->dislikes = $dislikes;
    }

    public function toArray(): array
    {
        $resultArray = [];
        if ($this->id) $resultArray['id'] = $this->id;
        if ($this->channelTitle) $resultArray['channel_title'] = $this->channelTitle;
        if ($this->channelUrl) $resultArray['channel_url'] = $this->channelUrl;
        if ($this->author) $resultArray['author'] = $this->author;
        if ($this->videoTitle) $resultArray['video_title'] = $this->videoTitle;
        if ($this->videoUrl) $resultArray['video_url'] = $this->videoUrl;
        if ($this->views) $resultArray['views'] = $this->views;
        if ($this->category) $resultArray['category'] = $this->category;
        if ($this->likes) $resultArray['likes'] = $this->likes;
        if ($this->dislikes) $resultArray['dislikes'] = $this->dislikes;

        return $resultArray;
    }
}