<?php

namespace App\Domain\Factories;

use App\Domain\Entities\NewsEntity;

interface NewsFactoryInterface
{
    public function create(string $date, string $url, string $title): NewsEntity;
}
