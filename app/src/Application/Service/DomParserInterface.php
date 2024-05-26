<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Dto\DomParserDto;

interface DomParserInterface
{
    public function parseTag(string $url, string $tag): DomParserDto;
}
