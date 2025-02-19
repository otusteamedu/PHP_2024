<?php

namespace App\Domain\Factory;

use App\Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $url, string $title, \DateTimeImmutable $date): News;
}
