<?php

namespace App\Domain\Strategy;

use App\Domain\Entity\News;

interface NewsStrategyInterface
{
    public function getText(News $news): string;
}