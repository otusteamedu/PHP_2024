<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Url
{
    private string $address;

    public function __construct(string $address)
    {
        $this->assertUrlIsValid($address);
        $this->address = $address;
    }

    public function getValue(): string
    {
        return $this->address;
    }

    private function assertUrlIsValid(string $address): void
    {
        $urlPattern = '/^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w.-]*)*\/?$/';
        if (!preg_match($urlPattern, $address)) {
            throw new InvalidArgumentException(
                "Некорректный url-адрес"
            );
        }
    }

    public function __toString(): string
    {
        return $this->address;
    }
}
