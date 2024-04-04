<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Posts;

use Hukimato\App\Models\DataMapper\PrimaryKey;

class Post
{
    #[PrimaryKey]
    private int $id;

    private string $title;

    private string $content;

    public function __construct(
        int    $id,
        string $title,
        string $content,

    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Post
    {
        $this->content = $content;
        return $this;
    }
}
