<?php

namespace App\Domain\Builder;

use App\Domain\Entity\News;
use App\Domain\ValueObject\Author;
use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\Title;

class NewsBuilder
{
    private Title              $title;
    private \DateTimeImmutable $date;
    private Author             $author;
    private Category           $category;
    private string             $text;

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

    public function setTitle(string $title): NewsBuilder
    {
        $this->title = new Title($title);
        return $this;
    }

    public function setDate(\DateTimeImmutable $date): NewsBuilder
    {
        $this->date = $date;
        return $this;
    }

    public function setAuthor(string $author): NewsBuilder
    {
        $this->author = new Author($author);
        return $this;
    }

    public function setCategory(string $category): NewsBuilder
    {
        $this->category = new Category($category);
        return $this;
    }

    public function setText(string $text): NewsBuilder
    {
        $this->text = $text;
        return $this;
    }


    public function build(): News
    {
        return new News($this);
    }
}

