<?php

namespace Src\Infrastructure\Repository;

use Src\Domain\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findEmailById(int $user_id): ?string
    {
        if (rand(0,1) === 0) {
            throw new \Exception('Email not found');
        }
        return 'test@test.com';
    }
}