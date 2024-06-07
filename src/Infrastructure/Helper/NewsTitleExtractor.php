<?php

declare(strict_types=1);

namespace App\Infrastructure\Helper;

use App\Application\Helper\DTO\NewsTitleDTO;
use App\Application\Helper\NewsTitleExtractorInterface;
use App\Application\Helper\DTO\NewsPageDTO;

class NewsTitleExtractor implements NewsTitleExtractorInterface
{
    public function extractTitle(NewsPageDTO $newsPageDTO): NewsTitleDTO
    {
        preg_match('/<title>(.*?)<\/title>/', $newsPageDTO->html, $matches);
        return new NewsTitleDTO($matches[1] ?? 'No title found');
    }
}
