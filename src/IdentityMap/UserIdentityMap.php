<?php

declare(strict_types=1);

namespace App\IdentityMap;

use App\User;

class UserIdentityMap
{
    /** @var User[] */
    private array $users = [];

    public function addUser(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function getUser(int $userId): ?User
    {
        return $this->users[$userId] ?? null;
    }
}
