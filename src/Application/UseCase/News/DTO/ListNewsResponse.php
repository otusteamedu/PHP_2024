<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\DTO;

use Illuminate\Support\Collection;
use JsonSerializable;

class ListNewsResponse implements JsonSerializable
{
    public readonly array $news;

    public function __construct(Collection $news)
    {
        $this->news = $news->map->toArray()->all();
    }

    public function jsonSerialize(): array
    {
        return $this->news;
    }
}
