<?php

namespace App\Application\UseCase\GetNewsList;

class NewsDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $url,
        public \DateTimeImmutable $date,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'title' => $this->title,
            'url' => $this->url,
        ];
    }

}
