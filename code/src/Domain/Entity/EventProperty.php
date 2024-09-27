<?php

declare(strict_types=1);

namespace IraYu\Hw12\Domain\Entity;

class EventProperty
{
    public function __construct(
        protected string $name,
        protected string $value,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
