<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Infrastructure\Factory;

use Asyrovatkin\Hw14\Domain\Entity\News;
use Asyrovatkin\Hw14\Domain\Factory\NewsFactoryInterface;
use Asyrovatkin\Hw14\Domain\ValueObject\Url;
use DateTime;

class CommonNewsFactory implements NewsFactoryInterface
{

    public function create(string $url): News
    {
        $news = new News();
        $news->setUrl(new Url($url));
        $news->setDate((new DateTime())->format('Y-m-d'));

        return $news;
    }
}