<?php

namespace App\Domain\Factory;

use App\Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $name, string $author, string $category, string $text): News;
}