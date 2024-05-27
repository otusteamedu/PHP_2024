<?php

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news);
    public function findById(int $id);

    public function getAllNews();

    public function getLastFiveNews();
}