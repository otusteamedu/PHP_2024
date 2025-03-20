<?php

namespace App\Domain\ValueObject;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        $this->assertValidName($name);
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function assertValidName(string $value)
    {
        if (mb_strlen($value) < 3) {
            throw new \InvalidArgumentException('Name must be at least 3 characters long');
        }
    }
}
