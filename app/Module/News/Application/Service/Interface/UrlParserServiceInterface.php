<?php

declare(strict_types=1);

namespace Module\News\Application\Service\Interface;

use Module\News\Application\Exception\CantParseUrlException;

interface UrlParserServiceInterface
{
    /**
     *
     * @throws CantParseUrlException
     */
    public function getTitle(string $url): string;
}
