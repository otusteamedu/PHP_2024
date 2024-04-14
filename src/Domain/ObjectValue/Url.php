<?php

declare(strict_types=1);

namespace App\Domain\ObjectValue;

class Url
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidUrl($value);
        $this->value = $value;
    }

    private function assertValidUrl(string $url): void
    {
        $pattern = '/^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w.-]*)*\/?$/';
        if (false === preg_match($pattern, $url)) {
            throw new \InvalidArgumentException('Invalid url');
        }
    }
    
    public function getValue(): string
    {
        return $this->value;
    }
}