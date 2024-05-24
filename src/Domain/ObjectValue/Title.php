<?php

declare(strict_types=1);

namespace App\Domain\ObjectValue;

class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidTitle($value);
        $this->value = $value;
    }

    private function assertValidTitle(string $title): void
    {
        if (mb_strlen($title) > 255 && mb_strlen($title) < 1) {
            throw new \InvalidArgumentException('Invalid title');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}