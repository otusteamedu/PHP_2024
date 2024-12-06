<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class NewsItem
{
    private ?int $id = null;

    public function __construct(
        private Title $title,
        private Url $url,
        private Date $date,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): NewsItem
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function setUrl(Url $url): NewsItem
    {
        $this->url = $url;

        return $this;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    public function setDate(Date $date): NewsItem
    {
        $this->date = $date;

        return $this;
    }
}
