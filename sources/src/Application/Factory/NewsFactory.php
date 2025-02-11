<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Entity\News;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use DateTimeImmutable;

class NewsFactory implements \App\Domain\Factory\NewsFactory
{

    public function create(string $url, string $title, DateTimeImmutable $date): News
    {
        return new News(
            (new Url($url))->getUrl(),
            (new Title($title))->getTitle(),
            $date
        );
    }
}