<?php

declare(strict_types=1);

namespace Module\News\Domain\Repository;

use Core\Domain\ValueObject\Uuid;
use Module\News\Domain\Entity\NewsCollection;

interface NewsQueryRepositoryInterface
{
    public function getAll(): NewsCollection;
    public function getAllByIds(Uuid $id, Uuid ...$ids): NewsCollection;
}
