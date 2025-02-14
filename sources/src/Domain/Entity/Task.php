<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\StatusEnum;

class Task
{
    private string $id;
    private string $status;

    public function __construct(
        private string $title
    )
    {
        $this->id = bin2hex(\random_bytes(16));
        $this->status = StatusEnum::PROGRESS->value;
    }

    public function setId(string $id): Task
    {
        $this->id = $id;
        return $this;
    }

    public function setStatus(string $status): Task
    {
        $this->status = $status;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}