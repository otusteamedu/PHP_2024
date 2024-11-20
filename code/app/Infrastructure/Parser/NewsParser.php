<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser;

use App\Application\Parser\NewsParseResult;
use App\Application\Parser\ParserInterface;

class NewsParser implements ParserInterface
{
    /**
     * @throws LoadHtmlException
     */
    public function parse(string $html): NewsParseResult
    {
        $res = preg_match("/<title>(.*)<\/title>/siU", $html, $title_matches);
        if (!$res) {
            throw new LoadHtmlException();
        }

        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);

        return new NewsParseResult(
            $title,
        );
    }
}
