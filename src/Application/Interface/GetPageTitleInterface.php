<?php

declare(strict_types=1);

namespace App\Application\Interface;

interface GetPageTitleInterface
{
    public function getPageTitle(string $url): ?string;
}
