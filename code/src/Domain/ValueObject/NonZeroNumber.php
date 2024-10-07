<?php

declare(strict_types=1);

namespace Viking311\Queue\Domain\ValueObject;

use InvalidArgumentException;

class NonZeroNumber
{
    /** @var int  */
    private int $value;

    /**
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        $this->assert($value);
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function assert(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Cannot be less thab 1');
        }
    }
}
