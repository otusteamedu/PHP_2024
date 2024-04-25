<?php

namespace AKornienko\Php2024\DataMapper;

class Post
{
    private int $id;

    private string $userId;
    private string $content;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
    ) {
        $this->id = $id;
        $this->userId = $firstName;
        $this->content = $lastName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
