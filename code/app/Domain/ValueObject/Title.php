<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Title
{
    /** @var string */
    private string $value;

    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct(string $value): void
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
            throw new InvalidArgumentException('Title can\'t be empty');
        }
    }
}
