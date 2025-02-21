<?php

namespace AnatolyShilyaev\Hw15\Domain\Factory;

use AnatolyShilyaev\Hw15\Domain\Entity\News;

interface NewsFactoryInterface
{
    public function create(string $url): News;
}
