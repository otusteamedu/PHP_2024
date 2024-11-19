<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Date
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidDate($value);
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidDate(string $value, $format = 'Y-m-d'): void
    {
        $d = \DateTime::createFromFormat($format, $value);
        $result = $d && strtolower($d->format($format)) === strtolower($value);

        if (!$result) {
            throw new \InvalidArgumentException('Invalid date. Need format Y-m-d');
        }
    }
}
