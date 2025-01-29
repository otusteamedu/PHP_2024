<?php

namespace Anatolyshilyaev\Hw14\Domain\Entity;

use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;

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
