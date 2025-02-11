<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Url
{
    private string $url;

    public function __construct(string $url)
    {
        $this->assertUrlIsValid($url);
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    private function assertUrlIsValid($url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Передан Url в неверном формате');
        }
    }
}