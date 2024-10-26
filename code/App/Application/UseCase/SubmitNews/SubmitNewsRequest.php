<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitNews;

class SubmitNewsRequest
{
    public string $name;
    public string $author;
    public string $category;
    public string $text;
    public function __construct(
        string $name,
        string $author,
        string $category,
        string $text
    )
    {
        $this->name = $name;
        $this->author = $author;
        $this->category = $category;
        $this->text = $text;
    }
}