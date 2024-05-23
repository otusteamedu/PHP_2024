<?php

declare(strict_types=1);

namespace Module\News\Domain\ValueObject;

use Module\News\Domain\Exception\IncorrectTitleLengthException;

use function mb_strlen;

final readonly class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureCorrectTitle($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function ensureCorrectTitle(string $value): void
    {
        $length = mb_strlen($value);
        if ($length === 0 || $length > 255) {
            throw new IncorrectTitleLengthException($value, 0, 255);
        }
    }
}
