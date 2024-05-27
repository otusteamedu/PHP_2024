<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use DateTimeInterface;

class News
{
    private int $id;

    public function __construct(
        private Title $title,
        private Url $url,
        private DateTimeInterface $createdAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
