<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\Validate\UrlValidateException;

class Url
{
    private string $url;

    /**
     * @throws UrlValidateException
     */
    public function __construct(string $value)
    {
        $this->isValidUrl($value);
        $this->url = $value;
    }

    public function getValue(): string
    {
        return $this->url;
    }

    public function __toString(): string
    {
        return $this->url;
    }

    /**
     * @throws UrlValidateException
     */
    private function isValidUrl(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new UrlValidateException('URL is not valid');
        }
    }
}
