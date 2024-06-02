<?php

declare(strict_types=1);

namespace App\IdentityMap;

use App\DataMapper\UserDataMapper;
use App\User;

class UserIdentityMap
{
    /** @var User[] */
    private array $users = [];
    private UserDataMapper $dataMapper;

    public function __construct(UserDataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }


    public function getUser(int $userId): User
    {
        if (empty($this->users[$userId])) {
            $this->users[$userId] = $this->dataMapper->getUserById($userId);
        }
        return $this->users[$userId];
    }
}
