<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Feed;
use DateTimeInterface;

interface FeedFactoryInterface
{
    public function create(DateTimeInterface $date, string $title, string $url): Feed;
}
