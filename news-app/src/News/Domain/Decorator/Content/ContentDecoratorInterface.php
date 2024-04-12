<?php

declare(strict_types=1);

namespace App\News\Domain\Decorator\Content;

use App\News\Domain\ValueObject\Content;

interface ContentDecoratorInterface
{
    public function getContent(): Content;
}