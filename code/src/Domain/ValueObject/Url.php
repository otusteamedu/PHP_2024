<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Domain\ValueObject;

use http\Exception\InvalidArgumentException;

class Url
{
    private string $url;

    public function __construct(string $url)
    {
        $this->validateUrl($url);
        $this->url = $url;
    }

    public function getValue(): string
    {
        return $this->url;
    }

    private function validateUrl(string $url): void
    {
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('URL is not valid!');
        }
    }
}