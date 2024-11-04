<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Entity\News;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;

class CommonNewsFactory implements NewsFactoryInterface
{
    public function create(string $url, string $title, \DateTimeImmutable $date = null): News
    {
        if (is_null($date)) {
            $date = new \DateTimeImmutable('now');
        }

        return new News(
            new Date($date),
            new Url($url),
            new Title($title)
        );
    }
}
