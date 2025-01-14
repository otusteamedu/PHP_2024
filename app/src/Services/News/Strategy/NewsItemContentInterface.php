<?php

namespace App\Services\News\Strategy;

interface NewsItemContentInterface
{
    public function getContent(string $content): string;
}
