<?php

declare(strict_types=1);

namespace App\News\Application\Request;

use App\NewsCategory\Domain\Entity\Category;

class CreateNewsRequest
{
    public function __construct(
        public string $title,
        public string $content,
        public int $categoryId
    )
    {

    }
}