<?php

declare(strict_types=1);

namespace App\Application\NewsList;

interface NewsListGeneratorInterface
{
    public function generate(): array;
}
