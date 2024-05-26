<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Dto\DomParserDto;
use App\Application\Service\DomParserInterface;

class DomParser implements DomParserInterface
{
    public function parseTag(string $url, string $tag): DomParserDto
    {
        $content = file_get_contents($url);
        $doc = new \DOMDocument();
        @$doc->loadHTML($content);
        $node = $doc->getElementsByTagName($tag)->item(0);

        return new DomParserDto($node->textContent);
    }
}
