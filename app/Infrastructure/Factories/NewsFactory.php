<?php

namespace App\Infrastructure\Factories;

use App\Domain\Entities\NewsEntity;
use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Values\Date;
use App\Domain\Values\Url;

class NewsFactory implements NewsFactoryInterface
{
    public function create(string $date, string $url, string $title): NewsEntity
    {
        return new NewsEntity(
            new Date($date),
            new Url($url),
            $title
        );
    }
}
