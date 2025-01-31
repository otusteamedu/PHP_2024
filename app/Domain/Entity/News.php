<?php

namespace Domain\Entity;

use Domain\ValueObject\Title;
use Domain\ValueObject\Url;

class News
{
    private ?int $id = null;
    private ?\DateTime $date;

    public function __construct(private readonly Title $title,
                                private readonly Url $url
    )
    {
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

}
