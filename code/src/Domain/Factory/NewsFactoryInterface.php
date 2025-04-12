<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Domain\Factory;

use Asyrovatkin\Hw14\Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $url): News;
}