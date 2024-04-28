<?php

declare(strict_types=1);

namespace App\Domain\Interface;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function addAndSaveNews(News $news): void;
}
