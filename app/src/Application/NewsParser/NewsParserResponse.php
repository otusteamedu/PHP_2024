<?php

namespace Anatolyshilyaev\Hw14\Application\NewsParser;

class NewsParserResponse
{
    public function __construct(
        public readonly string $title,
    ) {
        // Empty constructor
    }
}
