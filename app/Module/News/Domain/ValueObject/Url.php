<?php

declare(strict_types=1);

namespace Module\News\Domain\ValueObject;

use Module\News\Domain\Exception\IncorrectUrlException;

use function filter_var;

final readonly class Url
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureCorrectUrl($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function ensureCorrectUrl(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new IncorrectUrlException($value);
        }
    }
}
