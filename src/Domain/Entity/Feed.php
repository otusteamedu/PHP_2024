<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use DateTimeImmutable;

class Feed
{
    private ?int $id = null;

    function __construct(
        private readonly DateTimeImmutable $date,
        private readonly Title             $title,
        private readonly Url               $url,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
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
