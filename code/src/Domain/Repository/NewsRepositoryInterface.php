<?php

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;
    public function findById(int $id): array;

    public function getAllNews();

}