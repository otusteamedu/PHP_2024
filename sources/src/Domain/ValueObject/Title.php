<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertTitleIsValid($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertTitleIsValid(string $value): void
    {
        if (mb_strlen($value) < 2) {
            throw new \InvalidArgumentException('Название задачи должно быть больше двух символов');
        }
    }
}