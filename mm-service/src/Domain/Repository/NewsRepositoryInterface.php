<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): News;

    /**
     * @return News[]
     */
    public function findAll(): array;
}
