<?php

declare(strict_types=1);

namespace App\Application\Helper;

use App\Application\Helper\DTO\NewsPageDTO;
use App\Application\Helper\DTO\NewsTitleDTO;

interface NewsTitleExtractorInterface
{
    public function extractTitle(NewsPageDTO $newsPageDTO): NewsTitleDTO;
}
