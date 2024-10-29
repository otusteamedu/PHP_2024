<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Factory;

use Irayu\Hw15\Domain;
use Irayu\Hw15\Domain\Factory\NewsItemFactoryInterface;

class FirstFactory implements NewsItemFactoryInterface
{
    public function create(string $url, string $title, \DateTime $dateTime): Domain\Entity\NewsItem
    {
        return new Domain\Entity\NewsItem(
            new Domain\ValueObject\Url($url),
            new Domain\ValueObject\Title($title),
            new Domain\ValueObject\Date($dateTime),
        );
    }
}
