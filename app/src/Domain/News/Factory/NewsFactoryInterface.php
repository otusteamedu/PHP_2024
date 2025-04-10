<?php

declare(strict_types=1);

namespace Valen\App\Domain\News\Factory;

use Valen\App\Domain\News\Entity\News;
use Valen\App\Domain\News\Entity\Url;

interface NewsFactoryInterface
{
    public function create(Url $url, string $title, DateTime $date): News;
}
