<?php

declare(strict_types=1);

namespace Module\News\Domain\Repository;

use Core\Domain\ValueObject\Uuid;
use Module\News\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function create(News $news): void;
    public function update(News $news): void;
    /**
     * @return News[]
     */
    public function getAll(): array;
    /**
     * @return News[]
     */
    public function getAllByIds(Uuid ...$ids): array;
    public function getById(Uuid $id): News;
}
