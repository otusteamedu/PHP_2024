<?php

declare(strict_types=1);

namespace App\Application\Helper;

use App\Application\Gateway\Response\NewsResponse;

interface NewsTitleExtractorInterface
{
    public function extractTitle(NewsResponse $newsResponse): string;
}
