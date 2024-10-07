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
     * @throws InvalidArgumentException
     */
    public function __construct(string|DateTimeImmutable $value)
    {
        if (is_string($value)) {
            try {
                $this->value = new DateTimeImmutable($value);
            } catch (DateMalformedStringException $ex) {
                throw new InvalidArgumentException($ex->getMessage());
            }
        } else {
            $this->value = $value;
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
