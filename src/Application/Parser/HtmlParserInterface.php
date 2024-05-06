<?php

declare(strict_types=1);

namespace App\Application\Parser;

interface HtmlParserInterface
{
    public function parseTitle(string $html): string;
}