<?php

declare(strict_types=1);

namespace App\Domain\Entity\News;

use App\Domain\ValueObject\{NewsTitle, Url};
use Illuminate\Contracts\Support\Arrayable;

class News implements Arrayable
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

    public function fill(object $source): self
    {
        $this->id = $source->id;
        $this->date = $source->date;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'date' => $this->getDate(),
            'url' => $this->getUrl()->getValue(),
            'title' => $this->getTitle()->getValue(),
        ];
    }
}
