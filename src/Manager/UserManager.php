<?php

declare(strict_types=1);

namespace App\Manager;

use App\DataMapper\UserDataMapper;
use App\IdentityMap\UserIdentityMap;
use App\User;

readonly class UserManager
{
    public function __construct(private UserIdentityMap $userIdentityMap)
    {
    }

    public function getUserById(int $userId): User
    {
        return $this->userIdentityMap->getUser($userId);
    }
}
