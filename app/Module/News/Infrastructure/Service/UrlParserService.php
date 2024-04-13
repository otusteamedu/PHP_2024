<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Service;

use Module\News\Application\Exception\CantParseUrlException;
use Module\News\Application\Service\Interface\UrlParserServiceInterface;

use function preg_match;

final class UrlParserService implements UrlParserServiceInterface
{
    /**
     * @inheritDoc
     */
    public function getTitle(string $url): string
    {
        $content = file_get_contents($url);
        $regexp = '#<title>(.*)</title>#';
        preg_match($regexp, $content, $match);
        if (empty($match[1])) {
            throw new CantParseUrlException($url);
        }

        return $match[1];
    }
}
