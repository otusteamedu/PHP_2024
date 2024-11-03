<?php

declare(strict_types=1);

namespace App\Application\Helpers;

interface GetTitleInterface
{
    public function getTitle(GetTitleNewsRequest $request): GetTitleNewsResponse;
}
