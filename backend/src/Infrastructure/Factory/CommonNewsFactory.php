<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class CommonNewsFactory implements NewsFactoryInterface
{
    public function create(string $title, string $url, \DateTimeImmutable $date): News
    {
        return new News(
            new Date($date),
            new Url($url),
            new Title($title),
        );
    }
}
