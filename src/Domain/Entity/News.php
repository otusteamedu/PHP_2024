<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ObjectValue\Title;
use App\Domain\ObjectValue\Url;

class News
{
    private int $id;
    private \DateTime $createdDate;

    public function __construct(
        private Title $title,
        private Url $url
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): void
    {
        $this->title = $title;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function setUrl(Url $url): void
    {
        $this->url = $url;
    }

    public function getCreatedDate(): \DateTime
    {
        return $this->createdDate;
    }
}