<?php

declare(strict_types=1);

namespace Module\News\Domain\Repository;

use Core\Domain\ValueObject\Uuid;
use Module\News\Domain\Entity\News;

interface NewsQueryRepositoryInterface
{
    /**
     * @return News[]
     */
    public function getAll(): array;
    /**
     * @return News[]
     */
    public function getAllByIds(Uuid $id, Uuid ...$ids): array;
}
