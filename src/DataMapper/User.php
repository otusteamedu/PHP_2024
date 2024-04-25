<?php

namespace AKornienko\Php2024\DataMapper;

class User
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private string $birthdate;
    private array|null $posts = null;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $birthdate
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): string
    {
        return $this->birthdate;
    }

    public function setBirthDate(string $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPosts(): array|null
    {
        return $this->posts;
    }

    public function setPosts(array $posts): self
    {
        $this->posts = $posts;

        return $this;
    }
}
