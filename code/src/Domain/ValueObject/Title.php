<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\ValueObject;

class Title
{
    private string $value;

    public function __construct(string $value)
    {
        $this->checkCorrectness($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function checkCorrectness(string $value)
    {
        if (mb_strlen($value) < 3) {
            throw new \InvalidArgumentException(
                "Название должно содержать минимум 3 символа"
            );
        }
    }

    public function __toString(): string {
        return $this->value;
    }
}