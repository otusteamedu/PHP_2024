<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;

    public function __construct(
        private readonly Title $title,
        private readonly Url   $url,
        private readonly \DateTimeImmutable $date,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}
