<?php

namespace Irayu\Hw15\Domain\Factory;

use Irayu\Hw15\Domain;

interface NewsItemFactoryInterface
{
    public function create(string $url, string $title, \DateTime $dateTime): Domain\Entity\NewsItem;
}
