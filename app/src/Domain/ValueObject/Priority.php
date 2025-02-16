<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\ValueObject;

use http\Exception\InvalidArgumentException;

class Priority
{
    /** @var int */
    private int $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->assertValidPriority($value);
        $this->value = $value;
    }

    /**
     * Метод получает значение параметра
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Метод проверяет на валидность параметр
     *
     * @param int $value
     *
     * @return void
     */
    private function assertValidPriority(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('priority must be a positive number');
        }
    }
}
