<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\Exception\Validate\UrlValidateException;
use App\Domain\ValueObject\Url;

class PageTitleParser
{
    /**
     * @throws UrlValidateException
     */
    public function parsePageTitle(string $url): string
    {
        $content = file_get_contents((new Url($url))->getValue());
        preg_match("/<title>(.+?)<\/title>/", $content, $match);

        return $match[1] ?? '';
    }
}
