<?php

namespace App\Domain\Interface\Repository;

use App\Domain\Entity\News;
use App\Domain\ValueObject\Url;

interface NewsRepositoryInterface
{
    public function create(News $news): News;

    public function findById(int $id): ?News;

    public function findByUrl(Url $url): ?News;

    /**
     * @return ?News[]
     */
    public function findByIdArray(array $idArray): ?iterable;

    /**
     * @return News[]
     */
    public function findAll(): iterable;
}
