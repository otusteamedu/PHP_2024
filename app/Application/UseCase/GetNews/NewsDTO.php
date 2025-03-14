<?php

namespace App\Application\UseCase\GetNews;

class NewsDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public \DateTimeImmutable $date,
        public string $author,
        public string $category,
        public string $text,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date->format('Y-m-d'),
            'author' => $this->author,
            'category' => $this->category,
            'text' => $this->text,
        ];
    }
}
