<?php

declare(strict_types=1);

namespace App\Application\Service;

interface DomParserInterface
{
    public function parseTag(string $url, string $tag): string;
}
