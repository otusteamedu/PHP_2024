<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Request;

interface RequestRepositoryInterface
{
    public function findById(int $id): ?Request;

    public function save(Request $request): void;

    public function update(int $id, Request $request): void;
}
