<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\News;
use App\Domain\Entity\ValueObject\Name;
use App\Domain\Entity\ValueObject\Url;
use App\Domain\Factory\NewsFactoryInterface;
use Carbon\Carbon;

class CommonNewsFactory implements NewsFactoryInterface
{
    public function create(string $name, string $url, Carbon $createdAt): News
    {
        return new News(
            new Url($url),
            new Name($name),
            $createdAt
        );
    }
}
