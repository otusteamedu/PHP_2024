<?php

namespace App\Domain\Factory;

use App\Domain\Entity\News;
use Carbon\Carbon;

interface NewsFactoryInterface
{
    public function create(string $name, string $url, Carbon $createdAt): News;
}
