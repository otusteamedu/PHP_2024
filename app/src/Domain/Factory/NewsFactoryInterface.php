<?php

namespace Anatolyshilyaev\Hw14\Domain\Factory;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;

interface NewsFactoryInterface
{
    public function create(Title $title, Date $date, Url $url): News;
}
