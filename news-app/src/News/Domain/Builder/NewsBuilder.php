<?php

declare(strict_types=1);

namespace App\News\Domain\Builder;

use App\Common\Domain\ValueObject\DateTime;
use App\News\Domain\Entity\News;
use App\News\Domain\ValueObject\Content;
use App\News\Domain\ValueObject\Title;
use App\NewsCategory\Domain\Entity\Category;
use InvalidArgumentException;

class NewsBuilder
{
    private ?int $id = null;
    private Title $title;
    private DateTime $createdAt;
    private Content $content;
    private Category $category;

    public function setId(int $id): NewsBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle(Title $title): NewsBuilder
    {
        $this->title = $title;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): NewsBuilder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setContent(Content $content): NewsBuilder
    {
        $this->content = $content;
        return $this;
    }

    public function setCategory(Category $category): NewsBuilder
    {
        $this->category = $category;
        return $this;
    }

    public function build(): News
    {
        if (empty($this->title)) {
            throw new InvalidArgumentException('Title cannot be empty');
        }

        if (empty($this->content)) {
            throw new InvalidArgumentException('Content cannot be empty');
        }

        if (empty($this->category)) {
            throw new InvalidArgumentException('Category cannot be empty');
        }

        if (empty($this->createdAt)) {
            throw new InvalidArgumentException('Created at cannot be empty');
        }

        return new News(
            $this->id,
            $this->title,
            $this->createdAt,
            $this->content,
            $this->category
        );
    }
}