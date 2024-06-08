<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Dto\DomDto;
use App\Application\Dto\DomParserDto;
use App\Application\Service\DomParserInterface;

class DomParser implements DomParserInterface
{
    public function parseTag(DomDto $dto): DomParserDto
    {
        $content = file_get_contents($dto->url);
        $doc = new \DOMDocument();
        @$doc->loadHTML($content);
        $node = $doc->getElementsByTagName($dto->tag)->item(0);

        return new DomParserDto($node->textContent);
    }
}
