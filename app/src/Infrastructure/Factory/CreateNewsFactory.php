<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Infrastructure\Factory;

use PavelMiasnov\MediaMonitoring\Domain\Entity\News;
use PavelMiasnov\MediaMonitoring\Domain\Factory\NewsFactoryInterface;
use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Title;
use PavelMiasnov\MediaMonitoring\Domain\ValueObject\Url;

class CreateNewsFactory implements NewsFactoryInterface
{
    public function create(string $url, string $title): News
    {
        return new News(
            new Url($url),
            new Title($title)
        );
    }
}
