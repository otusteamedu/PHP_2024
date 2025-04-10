<?php

declare(strict_types=1);

namespace Valen\App\Domain\News\Entity;

use DateTime;
use Valen\App\Domain\News\ValueObject\Title;

class News
{
    private ?int $id;

    public function __construct(
        private Url $url,
        // Делали ли бы для даты отдельный ValueObject?
        private DateTime $date,
        private Title $title,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }
}
