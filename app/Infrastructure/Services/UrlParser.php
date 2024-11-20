<?php

namespace App\Infrastructure\Services;

use App\Domain\Services\UrlParserInterface;
use Symfony\Component\DomCrawler\Crawler;
use Exception;

class UrlParser implements UrlParserInterface
{
    public function extractText(string $url, string $tag, ?string $default = null): ?string
    {
        try {
            $html = file_get_contents($url);
            $crawler = new Crawler($html);
            $node = $crawler->filter($tag);

            if ($node->count() === 0) {
                return $default;
            }

            return $node->text();
        } catch (Exception $e) {
            throw new Exception("Could not parse $url. Error: " . $e->getMessage());
        }
    }
}
