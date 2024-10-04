<?php

declare(strict_types=1);

namespace Viking311\Queue\Domain\ValueObject;

use InvalidArgumentException;

class Email
{
    /** @var string  */
    private string $value;

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        $this->assert($value);
        $this->value = $value;
    }

    public function getVaule(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function assert(string $value): void
    {
        if(filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Email is invalid');
        }
    }
}
