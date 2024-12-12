<?php

declare(strict_types=1);

namespace App\Services\News\Observer;

use App\Entity\News;

class NewsItemCreateEvent
{
    public function __construct(public readonly News $newsItem)
    {
    }
}
