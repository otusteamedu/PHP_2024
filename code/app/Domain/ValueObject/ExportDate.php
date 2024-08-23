<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;

class ExportDate
{
    /** @var DateTimeImmutable */
    private DateTimeImmutable $value;

    /**
     * @param string|DateTimeImmutable $value
     * @return void
     * @throws InvalidArgumentException
     * @throws DateMalformedStringException
     */
    public function __construct(string|DateTimeImmutable $value)
    {
        if (is_string($value)) {
            $this->value = new DateTimeImmutable($value);
        } elseif ($value instanceof DateTimeImmutable) {
            $this->value = $value;
        } else {
            throw new InvalidArgumentException('Date is incorrect');
        }
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
