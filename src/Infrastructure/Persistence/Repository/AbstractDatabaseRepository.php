<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class AbstractDatabaseRepository
{
    protected static string $table;

    public function __construct(protected Manager $dbManager)
    {
    }

    public function findByIds(array $values): Collection
    {
        return $this->table()->whereIn('id', $values)->get();
    }

    public function all(): Collection
    {
        return $this->table()->get();
    }

    protected function table(): Builder
    {
        return $this->dbManager->table(static::$table);
    }
}
