<?php

declare(strict_types=1);

namespace App\Manager;

use App\DataMapper\UserDataMapper;
use App\IdentityMap\UserIdentityMap;
use App\User;

class UserManager
{
    public function __construct(private UserDataMapper $userDateMapper, private UserIdentityMap $userIdentityMap)
    {
    }

    public function getUserById(int $userId): User
    {
        $user = $this->userIdentityMap->getUser($userId);
        if (!$user) {
            $user = $this->userDateMapper->getUserById($userId);
            $this->userIdentityMap->addUser($user);
        }
        return $user;
    }
}
