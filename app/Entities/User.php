<?php

namespace App\Entities;

use App\Mappers\OrderMapper;

class User
{
    private ?array $orders = null;

    public function __construct(private ?int $id, private string $name, private string $email)
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getOrders(): array
    {
        if ($this->orders === null) {
            $this->orders = OrderMapper::findByUserId($this->id);
        }

        return $this->orders;
    }
}
