<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Domain\ValueObject;

class Url
{
    private string $url;

    public function __construct(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL');
        }
        $this->url = $url;
    }

    public function getValue(): string
    {
        return $this->url;
    }
}
