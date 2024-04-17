<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;

class News
{
    private int $id;

    public function __construct(
        private Url $url,
        private Title $title,
        private \DateTime $date = new \DateTime(),
        private string $status = 'created'
    ) {} // phpcs:ignore

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;
        return $this;
    }
}
