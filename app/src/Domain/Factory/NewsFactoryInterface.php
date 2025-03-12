<?php

declare(strict_types=1);

namespace PavelMiasnov\MediaMonitoring\Domain\Factory;

use PavelMiasnov\MediaMonitoring\Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $url, string $title): News;
}
