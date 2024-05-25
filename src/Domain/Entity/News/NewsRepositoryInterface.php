<?php

declare(strict_types=1);

namespace App\Domain\Entity\News;

use Illuminate\Support\Collection;

interface NewsRepositoryInterface
{
    public function save(News $news): void;

    public function findByIds(array $ids): Collection;

    public function all(): Collection;
}
