<?php

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{

    /**
     * @return News[]
     */
    public function get(array $ids);

    public function save(News $news): News;
}
