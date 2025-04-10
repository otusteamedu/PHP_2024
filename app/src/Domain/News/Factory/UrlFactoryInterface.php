<?php

declare(strict_types=1);

namespace Valen\App\Domain\News\Factory;

use Valen\App\Domain\News\Entity\Url;

interface UrlFactoryInterface
{
    public function create(string $url): Url;
}
