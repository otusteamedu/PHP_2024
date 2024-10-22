<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\NewsItem;
use App\Domain\Factory\NewsItemFactoryInterface;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class CommonNewsItemFactory implements NewsItemFactoryInterface
{
    public function create(string $title, string $url, \DateTime $date): NewsItem
    {
        return new NewsItem(
            new Title($title),
            new Url($url),
            new Date($date)
        );
    }
}
