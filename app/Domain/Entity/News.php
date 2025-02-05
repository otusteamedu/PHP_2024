<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;
    private ?\DateTime $date;

    public function __construct(private readonly Title $title,
                                private readonly Url $url
    ) {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
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

    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'title' => $this->title->getValue(),
            'url' => $this->url->getValue(),
        ];
    }
}
