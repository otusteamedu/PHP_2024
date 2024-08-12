<?php

declare(strict_types=1);

namespace App\Entity;

class RequestProcessEntity
{
    public function __construct(private int $id, private ?string $uuid)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
