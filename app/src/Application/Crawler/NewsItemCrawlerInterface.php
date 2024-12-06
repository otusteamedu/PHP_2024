<?php

declare(strict_types=1);

namespace App\Application\Crawler;

use App\Application\Crawler\Dto\NewsItemCrawlerRequestDto;
use App\Application\Crawler\Dto\NewsItemCrawlerResponseDto;

interface NewsItemCrawlerInterface
{
    public function getNewsItemByUrl(NewsItemCrawlerRequestDto $requestDto): NewsItemCrawlerResponseDto;
}
