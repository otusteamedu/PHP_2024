<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\ValueObject;

use http\Exception\InvalidArgumentException;

class Name
{
    /** @var string */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->assertValidName($value);
        $this->value = $value;
    }

    /**
     * Метод получает значение параметра
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Метод проверяет на валидность параметр
     *
     * @param string $value
     *
     * @return void
     */
    private function assertValidName(string $value): void
    {
        if (mb_strlen($value) < 3) {
            throw new InvalidArgumentException('Name must be at least 3 characters long');
        }
    }
}
