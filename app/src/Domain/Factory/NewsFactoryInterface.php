<?php

namespace Anatolyshilyaev\Hw14\Domain\Factory;

use Anatolyshilyaev\Hw14\Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $url): News;
}
