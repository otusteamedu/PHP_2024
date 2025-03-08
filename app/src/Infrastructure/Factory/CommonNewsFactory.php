<?php

namespace Anatolyshilyaev\Hw14\Infrastructure\Factory;

use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;

class CommonNewsFactory implements NewsFactoryInterface
{
    public function create(Title $title, Date $date, Url $url): News
    {
        return new News(
            $title,
            $date,
            $url
        );
    }
}
