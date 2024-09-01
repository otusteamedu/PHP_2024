<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\NewsEntity;

interface NewsRepositoryInterface
{
    public function findById(int $id): ?NewsEntity;

    public function save(NewsEntity $newsEntity): void;

    public function delete(NewsEntity $newsEntity): void;
}
