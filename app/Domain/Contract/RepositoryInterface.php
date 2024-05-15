<?php

namespace App\Domain\Contract;

interface RepositoryInterface
{
    public function save(array $dataRaw): EntityInterface;
    public function getAll(): array|false;
}
