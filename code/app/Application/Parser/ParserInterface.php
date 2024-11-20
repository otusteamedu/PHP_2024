<?php

declare(strict_types=1);

namespace App\Application\Parser;

interface ParserInterface
{
    public function parse(string $html): NewsParseResult;
}
