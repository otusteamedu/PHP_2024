<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Infrastructure\WebParser;

use Asyrovatkin\Hw14\Aplication\WebParser\WebParserInterface;
use Asyrovatkin\Hw14\Aplication\WebParser\WebParserRequest;
use Asyrovatkin\Hw14\Aplication\WebParser\WebParserResponse;

class WebParser implements WebParserInterface
{

    public function parse(WebParserRequest $request): WebParserResponse
    {
        $content = file_get_contents($request->getUrl()->getValue());
        $res = preg_match("/<title>(.*)<\/title>/siU", $content, $title_matches);
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return new WebParserResponse($title);
    }
}