<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Mapper;

use App\Domain\Entity\News;
use App\Infrastructure\Persistence\Doctrine\Entity\DoctrineNews;

class NewsMapper extends EntityMapper
{
    protected string $doctrineClass = DoctrineNews::class;
    protected string $domainClass = News::class;
}