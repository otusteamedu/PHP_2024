<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\ValueObject\ExportDate;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use DateTimeImmutable;

class NewsFactory implements NewsFactoryInterface
{
    public function __construct(
        private NewsLoader $loader
    ) {}

    public function create(string $url): News
    {
        $title = $this->loader->getTitle($url);

        return new News(
            new Url($url),
            new Title($title),
            new ExportDate(
                new DateTimeImmutable()
            )
        );
    }
}
