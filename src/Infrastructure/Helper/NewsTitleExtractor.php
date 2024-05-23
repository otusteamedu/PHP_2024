<?php

declare(strict_types=1);

namespace App\Infrastructure\Helper;

use App\Application\Gateway\Response\NewsResponse;
use App\Application\Helper\NewsTitleExtractorInterface;

class NewsTitleExtractor implements NewsTitleExtractorInterface
{
    public function extractTitle(NewsResponse $newsResponse): string
    {
        preg_match('/<title>(.*?)<\/title>/', $newsResponse->html, $matches);
        return $matches[1] ?? 'No title found';
    }
}
