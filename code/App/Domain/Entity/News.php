<?php

namespace App\Domain\Entity;

use App\Domain\Output\AppendedTextInterface;
use App\Domain\Output\NewsPrepareTextInterface;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Text;
use App\Domain\ValueObject\Author;
use App\Domain\ValueObject\Category;
use DateTime;

class News implements AppendedTextInterface
{
    private ?int $id = null;
    private ?DateTime $date_created = null;
    private Name $name;
    private Author $author;
    private Category $category;
    private Text $text;

    public function __construct(
        Name $name,
        Author $author,
        Category $category,
        Text $text
    )
    {
        $this->name = $name;
        $this->author = $author;
        $this->category = $category;
        $this->text = $text;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getDateCreated(): ?DateTime
    {
        return $this->date_created;
    }
    public function getName(): Name
    {
        return $this->name;
    }
    public function getAuthor(): Author
    {
        return $this->author;
    }
    public function getCategory(): Category
    {
        return $this->category;
    }
    public function getText(): Text
    {
        return $this->text;
    }
}
