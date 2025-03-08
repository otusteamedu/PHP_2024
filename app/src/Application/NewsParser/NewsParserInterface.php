<?php

namespace Anatolyshilyaev\Hw14\Application\NewsParser;

use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;

interface NewsParserInterface
{
    public function parse(Url $url): ?string;
}
