<?php

namespace Ahar\hw15\src\Domain\Model;

class News
{
    public ?int $id = null;

    public function __construct(
        public string $title,
        public string $description,
    )
    {
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
