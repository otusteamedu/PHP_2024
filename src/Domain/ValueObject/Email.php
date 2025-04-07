<?php

namespace SergeyShirykalov\HomeworkRabbit\Domain\ValueObject;

class Email
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidEmail($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidEmail(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Invalid email: ' . $value);
        }
    }
}
