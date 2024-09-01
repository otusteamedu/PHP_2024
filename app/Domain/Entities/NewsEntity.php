<?php

namespace App\Domain\Entities;

use App\Domain\Values\Date;
use App\Domain\Values\Url;

class NewsEntity
{
    private ?int $id = null;

    public function __construct(
        private Date $date,
        private Url $url,
        private string $title
    ) {}

    public function setId(int $value): void
    {
        if ($this->id === null) {
            $this->id = $value;
        }
    }

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
