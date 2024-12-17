<?php

namespace App\Domain\ValueObject;
class Path
{
    private string $value;

    public function __construct(?string $value)
    {
        $this->assertValidPath($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidPath(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Directory path is required');
        }
        if (file_exists($value)) {
            throw new \InvalidArgumentException('Should be valid directory path');
        }
    }

}