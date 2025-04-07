<?php

namespace SergeyShirykalov\HomeworkRabbit\Domain\ValueObject;

class UserData
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidData($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidData(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Invalid data: ' . $value);
        }
    }

}