<?php

namespace App\Entities;

use App\Mappers\UserMapper;

class Order
{
    private ?User $user = null;

    public function __construct(
        private ?int $id,
        private int $user_id,
        private string $productName,
        private float $amount
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getUser(): ?User
    {
        if ($this->user === null) {
            $this->user = UserMapper::findById($this->user_id);
        }

        return $this->user;
    }
}
