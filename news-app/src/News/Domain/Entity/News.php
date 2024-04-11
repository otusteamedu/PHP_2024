<?php

declare(strict_types=1);

namespace App\News\Domain\Entity;

use App\Common\Domain\ValueObject\DateTime;
use App\News\Domain\Decorator\Content\ContentDecoratorInterface;
use App\News\Domain\ValueObject\Content;
use App\News\Domain\ValueObject\Title;
use App\NewsCategory\Domain\Entity\Category;

class News implements ContentDecoratorInterface
{
    public function __construct(
        private readonly ?int $id,
        private Title $title,
        private DateTime $createdAt,
        private Content $content,
        private Category $category
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function setTitle(Title $title): void
    {
        $this->title = $title;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function setContent(Content $content): void
    {
        $this->content = $content;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
}