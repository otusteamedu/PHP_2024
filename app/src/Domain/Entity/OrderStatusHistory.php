<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Entity;

class OrderStatusHistory
{
    private ?int $id;
    private int $foodItemId;
    private string $status;
    private \DateTimeImmutable $createdAt;

    public function __construct(int $foodItemId, string $status)
    {
        $this->id = null;
        $this->foodItemId = $foodItemId;
        $this->status = $status;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoodItemId(): int
    {
        return $this->foodItemId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    // Для рефлексии ID
    public function setId(int $id): void
    {
        $reflection = new \ReflectionProperty($this::class, 'id');
        $reflection->setAccessible(true);
        $reflection->setValue($this, $id);
    }
}
