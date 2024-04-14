<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\HtmlParserInterface;
use App\Domain\Exception\DomainException;

class HtmlParser implements HtmlParserInterface
{
    public function parseTitle(string $html): string
    {
        if (!preg_match('~<title>(.*?)</title>~siu', $html, $matches) ) {
            throw new DomainException('Failed to parse title');
        }

        return $matches[1] ?? '';
    }
}