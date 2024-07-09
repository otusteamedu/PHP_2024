<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Query\Builder;

abstract class AbstractDatabaseRepository
{
    protected static string $table;

    public function __construct(protected Manager $dbManager)
    {
    }

    public function findById(int $id): object
    {
        $data = $this->table()->find($id);

        if (!$data) {
            throw new DomainRecordNotFoundException();
        }

        return $data;
    }

    protected function table(): Builder
    {
        return $this->dbManager->table(static::$table);
    }
}
