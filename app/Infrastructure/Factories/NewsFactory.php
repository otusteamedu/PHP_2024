<?php

namespace App\Infrastructure\Factories;

use App\Domain\Entities\NewsEntity;
use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Values\Url;
use DateTimeImmutable;

class NewsFactory implements NewsFactoryInterface
{
    public function create(string $date, string $url, string $title): NewsEntity
    {
        return new NewsEntity(
            new DateTimeImmutable($date),
            new Url($url),
            $title
        );
    }
}
