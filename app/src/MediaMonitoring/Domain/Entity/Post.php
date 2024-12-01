<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Domain\Entity;

use DateTimeInterface;

final class Post
{
    public function __construct(
        private ?PostId $id,
        private PostTitle $title,
        private DateTimeInterface $date,
        private PostUrl $url,
    ) {}

    public function getId(): ?PostId
    {
        return $this->id;
    }

    public function getTitle(): PostTitle
    {
        return $this->title;
    }

    public function setTitle(PostTitle $title): Post
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): Post
    {
        $this->date = $date;

        return $this;
    }

    public function getUrl(): PostUrl
    {
        return $this->url;
    }

    public function setUrl(PostUrl $url): Post
    {
        $this->url = $url;

        return $this;
    }
}
