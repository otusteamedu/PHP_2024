<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Aplication\WebParser;

interface WebParserInterface
{
    public function parse(WebParserRequest $request): WebParserResponse;
}