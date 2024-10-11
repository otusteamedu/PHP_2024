<?php

declare(strict_types=1);

namespace Viking311\Api\Domain\ValueObject;

use InvalidArgumentException;

class Name
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

    /**
     * @return string
     */
    public function getValue(): string
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
        if (empty($value)) {
            throw new InvalidArgumentException('Name cannot be empty');
        }
    }
}
