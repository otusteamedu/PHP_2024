<?php

declare(strict_types=1);

namespace App\Application\Gateway\Crawler;

interface DomCrawler
{
    public function getTitle(DomCrawlerRequest $request): DomCrawlerResponse;
}