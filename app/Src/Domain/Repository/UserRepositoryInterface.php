<?php

namespace Src\Domain\Repository;

interface UserRepositoryInterface
{
    public function findEmailById(int $user_id): ?string;
}
