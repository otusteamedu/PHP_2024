<?php

namespace App\Domain\Entity;

use App\Domain\Builder\NewsBuilder;
use App\Domain\ValueObject\Author;
use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\Title;

class News
{
    private ?int $id = null;
    private Title              $title;
    private \DateTimeImmutable $date;
    private Author             $author;
    private Category           $category;
    private string             $text;


    public function __construct(NewsBuilder $newsBuilder)
    {
        $this->title = $newsBuilder->getTitle();
        $this->date = $newsBuilder->getDate();
        $this->author = $newsBuilder->getAuthor();
        $this->category = $newsBuilder->getCategory();
        $this->text = $newsBuilder->getText();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
