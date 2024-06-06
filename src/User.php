<?php

declare(strict_types=1);

namespace App;

readonly class User
{
    public function __construct(private int $id, private string $name, private string $email)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
