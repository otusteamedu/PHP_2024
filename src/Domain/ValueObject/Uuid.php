<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Exception;

class Uuid
{
    private string $value;

    /**
     * @throws Exception
     */
    public function __construct(string $value)
    {
        $this->assertUuidIsValid($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @throws Exception
     */
    private function assertUuidIsValid(string $value): void
    {
        if (!preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $value)) {
            throw new Exception(
                "Передан некорректный uuid: {$value}"
            );
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
