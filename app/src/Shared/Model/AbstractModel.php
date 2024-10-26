<?php

declare(strict_types=1);

namespace App\Shared\Model;

abstract class AbstractModel
{
    protected array $dirtyFields = [];

    public function __construct(
        private ?int $id,
    ) {}

    abstract public function toArray(): array;

    abstract public static function fromArray(array $data): static;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function isNew(): bool
    {
        return null === $this->getId();
    }

    public function isDirty(string $field): bool
    {
        return isset($this->dirtyFields[$field]);
    }

    public function getDirtyFields(): array
    {
        return $this->dirtyFields;
    }

    public function resetDirtyFields(): void
    {
        $this->dirtyFields = [];
    }

    protected function markDirty(string $field): void
    {
        $this->dirtyFields[$field] = true;
    }
}
