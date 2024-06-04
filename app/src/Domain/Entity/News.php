<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Entity;

use Kagirova\Hw21\Domain\Builder\NewsBuilder;
use Kagirova\Hw21\Domain\Decorator\NewsInterface;

class News implements NewsInterface
{
    private int $id;
    private string $name;
    private string $date;
    private string $author;
    private Category $category;
    private string $text;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function __construct(NewsBuilder $newsBuilder)
    {
        if ($newsBuilder->getId() !== -1){
            $this->id = $newsBuilder->getId();
        }
        $this->name = $newsBuilder->getName();
        $this->date = $newsBuilder->getDate();
        $this->author = $newsBuilder->getAuthor();
        $this->category = $newsBuilder->getCategory();
        $this->text = $newsBuilder->getText();
    }

    public function printNews()
    {
        return array(
            "id" => $this->id,
            "name" => $this->name,
            "date" => $this->date,
            "author" => $this->author,
            "category" => $this->category->getName(),
            "text" => $this->text
        );
    }
}
