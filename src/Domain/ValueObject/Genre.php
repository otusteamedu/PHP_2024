<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Enum\AllowedGenreEnum;
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
        $this->assertGenreLength($value);
        $this->assertGenreName($value);
        $this->value = $value;
    }

    private function assertGenreLength(string $value): void
    {
        if (strlen($value) > 60) {
            throw new InvalidArgumentException('Длина наименования жанра не должна превышать 60 символов');
        }
    }
    private function assertGenreName(string $value): void
    {
        if (is_null(AllowedGenreEnum::tryFrom($value))) {
            throw new InvalidArgumentException('Неизвестный жанр');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
