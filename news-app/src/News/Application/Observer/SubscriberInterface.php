<?php

declare(strict_types=1);

namespace App\News\Application\Observer;

use App\News\Domain\Entity\News;

interface SubscriberInterface
{
    public function run(News $news): void;
}