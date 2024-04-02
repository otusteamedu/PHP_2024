<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Entities;

class Hall
{
    private int $id;

    private string $name;

    public function __construct(
        int $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setNumber(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
