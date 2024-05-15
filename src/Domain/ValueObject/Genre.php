<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Genre
{
    private string $value;

    public function __construct(
        string $value
    ) {
        $this->setValue($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function setValue(string $value): void
    {
        $this->assertUrl($value);
        $this->value = $value;
    }

    private function assertUrl(string $value): void
    {
        if (strlen($value) > 60) {
            throw new InvalidArgumentException('Длина наименования жанра не должна превышать 60 символов');
        }
    }
}
