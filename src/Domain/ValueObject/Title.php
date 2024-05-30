<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Title
{
    private string $value;

    public function __construct(
        string $value
    ) {
        $this->assertLength($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertLength(string $value): void
    {
        if (strlen($value) > 255) {
            throw new InvalidArgumentException('Длина заголовка новости не должна превышать 255 символов');
        }
    }
}
