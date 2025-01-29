<?php

namespace Anatolyshilyaev\Hw14\Domain\ValueObject;

class Date
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidDate($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function assertValidDate(string $value): void
    {
        $format = 'Y-m-d';
        $date = \DateTime::createFromFormat($format, $value);

        if (!$date) {
            throw new \InvalidArgumentException("The value is not s Date");
        }
        if ($date->format($format) !== $value) {
            throw new \InvalidArgumentException("Wrong date format");
        }
    }
}
