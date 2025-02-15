<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Feed;

interface FeedRepositoryInterface
{
    /**
     * @return Feed[]
     */
    public function getAll(FeedAllParameters $parameters): iterable;

    /**
     * @return Feed[]
     */
    public function findByIds(array $ids): iterable;

    public function findById(int $id): ?Feed;

    public function save(Feed $feed): void;

    public function delete(Feed $feed): void;
}
