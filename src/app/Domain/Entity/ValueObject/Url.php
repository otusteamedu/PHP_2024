<?php

namespace App\Domain\Entity\ValueObject;

class Url
{
    private string $url;

    public function __construct(string $url) {
        $this->assertValidUrl($url);
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    private function assertValidUrl(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Url некорректно');
        }
    }
}
