<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\Event;

final readonly class Criteria
{
    public function __construct(
        private string $name,
        private string|float $value
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): float|string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
