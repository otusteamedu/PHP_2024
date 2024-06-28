<?php

declare(strict_types=1);

namespace App\Domain\CustomerTask;

use JsonSerializable;

class Task implements JsonSerializable
{
    private ?int $id;

    private string $name;

    private string $description;
    private mixed $status;

    public function __construct(?int $id, string $name, string $description, mixed $status = null)
    {
        $this->id = $id;
        $this->name = strtolower($name);
        $this->description = ucfirst($description);
        $this->status = $status;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        if (!$this->status) {
            return 'in process';
        }
        return $this->status;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
