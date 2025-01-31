<?php

namespace Domain\Factory;

use Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $url, string $title): News;
}
