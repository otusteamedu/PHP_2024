<?php

namespace App\Domain\Services;

interface UrlParserInterface
{
    public function extractText(string $url, string $tag, ?string $default = null): ?string;
}
