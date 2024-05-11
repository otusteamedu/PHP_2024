<?php

declare(strict_types=1);

namespace Pozys\Php2024\ValueObject;

class Url
{
    private string $value;

    public function __construct(string $value)
    {
        if (!$this->isValidUrl($value)) {
            throw new \InvalidArgumentException('Invalid URL');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function isValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
