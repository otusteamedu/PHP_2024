<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Builder;

use Kagirova\Hw21\Domain\Entity\Category;
use Kagirova\Hw21\Domain\Entity\News;

class NewsBuilder
{
    private int $id = -1;
    private string $name;
    private string $date;
    private string $author;
    private Category $category;
    private string $text;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): NewsBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): NewsBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): NewsBuilder
    {
        $this->date = $date;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): NewsBuilder
    {
        $this->author = $author;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(int $id, string $category): NewsBuilder
    {
        $this->category = new Category($id, $category);
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): NewsBuilder
    {
        $this->text = $text;
        return $this;
    }

    public function build()
    {
        return new News($this);
    }
}
