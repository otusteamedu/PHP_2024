<?php

namespace App\Services\News\Strategy;

interface NewsItemContent
{
    public function getContent(string $content): string;
}
