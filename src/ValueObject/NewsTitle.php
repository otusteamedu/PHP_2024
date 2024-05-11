<?php

declare(strict_types=1);

namespace Pozys\Php2024\ValueObject;

class NewsTitle
{
    private string $value;

    public function __construct(string $value)
    {
        if (!$this->isValidTitle($value)) {
            throw new \InvalidArgumentException('Invalid title');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function isValidTitle(string $title): bool
    {
        if (trim($title) === '' || strlen($title) > 255) {
            return false;
        }

        return true;
    }
}
