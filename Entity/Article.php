<?php

declare(strict_types=1);

namespace AKagirova\Hw17;

class Article
{
    private ?string $title = null;
    private ?string $text = null;
    private ?int $authorId = null;

    public function __construct(?string $title, ?string $text, ?int $authorId)
    {
        $this->title = $title;
        $this->text = $text;
        $this->authorId = $authorId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setTitle(?string $title)
    {
        $this->title = $title;
    }

    public function setText(?string $text)
    {
        $this->text = $text;
    }

    public function setAuthorId(?int $authorId)
    {
        $this->authorId = $authorId;
    }
}
