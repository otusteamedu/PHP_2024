<?php

namespace App\Domain\Output;

use App\Domain\Entity\News;

interface NewsPrepareTextInterface
{
    public function prepareText(News $news): string;
}