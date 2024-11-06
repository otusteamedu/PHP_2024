<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Domain\Repository;

use App\MediaMonitoring\Domain\Entity\Post;
use App\Shared\Domain\Exception\CouldNotSaveEntityException;

interface PostRepositoryInterface
{
    /**
     * @return Post[]
     */
    public function findAll(): array;

    /**
     * @param int[] $ids
     *
     * @return Post[]
     */
    public function findByIds(array $ids): array;

    /**
     * @throws CouldNotSaveEntityException
     */
    public function save(Post $post): Post;
}
