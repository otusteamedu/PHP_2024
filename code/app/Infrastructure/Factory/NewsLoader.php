<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use DOMDocument;

class NewsLoader
{
    public function getTitle(string $url): string
    {
        $fp = file_get_contents($url);
        if (!$fp) {
            throw new LoadHtmlException();
        }

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res) {
            throw new LoadHtmlException();
        }

        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);

        return $title;
    }
}
