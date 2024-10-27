<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetNews;

class GetNewsResponse
{
    public int $id;
    public string $text;
    public string $date_created;
    public string $author;
    public string $category;
    public string $name;
    public function __construct(
        int $id,
        string $text,
        string $date_created,
        string $author,
        string $category,
        string $name
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->date_created = $date_created;
        $this->author = $author;
        $this->category = $category;
        $this->name = $name;
    }
}