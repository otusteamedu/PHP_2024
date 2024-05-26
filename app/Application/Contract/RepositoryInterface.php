<?php

namespace App\Application\Contract;

interface RepositoryInterface
{
    public function getAll(): array;
    public function getLastInsertId(): int;
}
