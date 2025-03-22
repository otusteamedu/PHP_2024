<?php

namespace Anatolyshilyaev\Hw14\Application\NewsParser;

interface NewsParserInterface
{
    /**
     * @param NewsParserRequest $newsParserRequest
     * @return ?NewsParserResponse $newsParserResponse
     */
    public function parse(NewsParserRequest $request): ?NewsParserResponse;
}
