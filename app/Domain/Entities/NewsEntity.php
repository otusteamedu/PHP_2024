<?php

namespace App\Domain\Entities;

use App\Domain\Values\Url;
use DateTimeImmutable;

class NewsEntity
{
    private ?int $id = null;

    public function __construct(
        private DateTimeImmutable $date,
        private Url $url,
        private string $title
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
