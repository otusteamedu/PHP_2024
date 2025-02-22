<?php

namespace App\Infrastructure\Service\Factory;

use App\Domain\Entity\Feed;
use App\Domain\Factory\FeedFactoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use DateTimeImmutable;
use DateTimeInterface;

class CommonFeedFactory implements FeedFactoryInterface
{
    public function create(DateTimeImmutable|DateTimeInterface $date, string $title, string $url): Feed
    {
        return new Feed($date, new Title($title), new Url($url));
    }
}
