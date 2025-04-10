<?php

declare(strict_types=1);

namespace Valen\App\Domain\News\Entity;

readonly class Url
{
    public function __construct(
        public string $url
    ) {
        $this->validate($url);
    }

    private function validate(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Недопустимый URL: {$url}");
        }

        // Дополнительно можно проверить наличие протокола (http или https)
        $parsed = parse_url($url);
        if (!isset($parsed['scheme']) || !in_array($parsed['scheme'], ['http', 'https'])) {
            throw new \InvalidArgumentException("URL должен начинаться с http:// или https://");
        }
    }
}
