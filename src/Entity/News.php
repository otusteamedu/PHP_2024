<?php

declare(strict_types=1);

namespace Pozys\Php2024\Entity;

use Pozys\Php2024\ValueObject\{NewsTitle, Url};

class News
{
    private int $id;
    private string $date;

    public function __construct(private Url $url, private NewsTitle $title)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getTitle(): NewsTitle
    {
        return $this->title;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}
