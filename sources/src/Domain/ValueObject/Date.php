<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Date
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertIsValidDate($value);
        $this->value = $value;
    }

    public function getValue(): \DateTime
    {
        return \DateTime::createFromFormat("d.m.Y", $this->value);
    }

    private function assertIsValidDate(string $value): void
    {
        $date = \DateTime::createFromFormat('d.m.Y', $value);

        $result = $date && strtolower($date->format('d.m.Y')) === strtolower($value);

        if (!$result) {
            throw new \InvalidArgumentException('Неверная дата');
        }
    }
}