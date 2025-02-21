<?php

namespace AnatolyShilyaev\Hw15\Domain\Entity;

use AnatolyShilyaev\Hw15\Domain\ValueObject\Title;
use AnatolyShilyaev\Hw15\Domain\ValueObject\Date;
use AnatolyShilyaev\Hw15\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;

    public function __construct(
        private Title $title,
        private Date $date,
        private Url $url
    ) {
        // Empty constructor
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): Title
    {
        return $this->title;
    }
    public function getDate(): Date
    {
        return $this->date;
    }
    public function getUrl(): Url
    {
        return $this->url;
    }
}
