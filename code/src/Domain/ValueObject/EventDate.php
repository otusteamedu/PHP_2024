<?php

declare(strict_types=1);

namespace Viking311\Queue\Domain\ValueObject;

use DateMalformedStringException;
use DateTimeImmutable;
use InvalidArgumentException;

class EventDate
{
    /** @var DateTimeImmutable */
    private DateTimeImmutable $value;

    /**
     * @param string|DateTimeImmutable $value
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

    /**
     * @return DateTimeImmutable
     */
    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }
}
