<?php

declare(strict_types=1);

namespace Irayu\Hw15\Domain\ValueObject;

class Url
{
    private string $value;

    public function __construct(string $value)
    {
        $this->checkCorrectness($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function checkCorrectness(string $value)
    {
        if (preg_match("/^((https?):\/\/)/", $value) === false) {
            throw new \InvalidArgumentException(
                "Адрес новости должен начинаться с http:// или https://"
            );
        }
        if (preg_match("/^(https?:\/\/)(www\.)?[a-z0-9\-]+(\.[a-z]{2,})([^\s]*)?$/", $value) === false) {
            throw new \InvalidArgumentException(
                "Адрес новости должен быть валидным URL адресом"
            );
        }
    }

    public function __toString(): string {
        return $this->value;
    }
}