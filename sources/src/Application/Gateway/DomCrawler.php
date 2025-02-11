<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface DomCrawler
{
    public function getTitle(DomCrawlerRequest $request): DomCrawlerResponse;
}