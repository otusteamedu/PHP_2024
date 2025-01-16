<?php

declare(strict_types=1);

namespace App\Services\News\Decorator;

interface NewsItemContentInterface
{
    public function getContent(): string;
}
