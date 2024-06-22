<?php

declare(strict_types=1);

namespace App\ObjectValue;

use App\Exception\InvalidArgumentException;

readonly class Money
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(private int $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Invalid money amount');
        }
    }
    public function getAmount(): int
    {
        return $this->amount;
    }
}
