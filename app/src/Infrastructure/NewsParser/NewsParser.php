<?php

namespace Anatolyshilyaev\Hw14\Infrastructure\NewsParser;

use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserInterface;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserRequest;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserResponse;

class NewsParser implements NewsParserInterface
{
    public function parse(NewsParserRequest $request): ?NewsParserResponse
    {
        $fp = file_get_contents($request->url, false);
        if (!$fp) {
            return null;
        }

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res) {
            return null;
        }

        // Clean up title: remove EOL's and excessive whitespace.
        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return new NewsParserResponse($title);
    }
}
