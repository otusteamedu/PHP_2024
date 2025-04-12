<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Domain\Entity;

use Asyrovatkin\Hw14\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;
    private Url|string $url;
    private string $title;
    private string $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUrl(Url $url): void
    {
        $this->url = $url;
    }

    public function getUrl(): Url
    {
        if (is_string($this->url)) {
            return new Url($this->url);
        }
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }

}