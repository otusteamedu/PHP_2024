<?php

declare(strict_types=1);

namespace App\Domain\Entity\News;

use Illuminate\Support\Collection;

interface NewsRepositoryInterface
{
    public function save(News $news): int;

    public function findWhereIn(array $values, ?string $column = 'id'): Collection;

    public function all(): Collection;
}
