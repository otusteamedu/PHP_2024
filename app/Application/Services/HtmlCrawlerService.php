<?php

namespace App\Application\Services;

use Exception;
use Symfony\Component\DomCrawler\Crawler;

class HtmlCrawlerService
{
    private string $html;

    public function __construct(string $url)
    {
        if (! $html = file_get_contents($url)) {
            throw new Exception("Could not parse $url.");
        }

        $this->html = $html;
    }

    public function extractTextFromTag(string $tag, ?string $default = null): ?string
    {
        $node = (new Crawler($this->html))->filter($tag);

        if ($node->count() === 0) {
            return $default;
        }

        return $node->text();
    }
}
