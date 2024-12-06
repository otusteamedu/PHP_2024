<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\NewsItem;

interface NewsItemFactoryInterface
{
    public function create(string $title, string $url, \DateTimeImmutable $date): NewsItem;
}
