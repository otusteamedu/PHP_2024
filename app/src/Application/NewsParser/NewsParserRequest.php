<?php

namespace Anatolyshilyaev\Hw14\Application\NewsParser;

class NewsParserRequest
{
    public function __construct(
        public readonly string $url
    ) {
        // Empty constructor
    }
}
