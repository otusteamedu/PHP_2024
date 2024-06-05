<?php

declare(strict_types=1);

namespace Core\Domain\ValueObject;

use Core\Domain\Exception\IncorrectUuidException;

final readonly class Uuid
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureCorrectUuid($value);
        $this->value = $value;
    }


    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    private function ensureCorrectUuid(string $value): void
    {
        $regex = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
        if (!preg_match($regex, $value)) {
            throw new IncorrectUuidException($value);
        }
    }
}
