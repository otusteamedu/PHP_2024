<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $title, string $url, \DateTimeImmutable $date): News;
}
