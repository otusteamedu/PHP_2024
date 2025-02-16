<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\ValueObject;

use http\Exception\InvalidArgumentException;

class Param
{
    /** @var int */
    private int $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->assertValidParam($value);
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
    private function assertValidParam(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('param must be a positive number');
        }
    }
}
