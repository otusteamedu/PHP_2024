<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\News;
use DateTimeImmutable;

interface NewsFactory
{
    public function create(string $url, string $title, DateTimeImmutable $date): News;
}