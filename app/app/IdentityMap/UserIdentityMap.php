<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\IdentityMap;

use Rmulyukov\Hw\Entity\User;
use Rmulyukov\Hw\Entity\UserCollection;

final readonly class UserIdentityMap
{
    private UserCollection $users;

    public function __construct()
    {
        $this->users = new UserCollection();
    }

    public function get(string $uuid): ?User
    {
        return $this->users->get($uuid);
    }

    public function add(User $user): void
    {
        $this->users->add($user);
    }

    public function addCollection(UserCollection $users): void
    {
        foreach ($users->all() as $user) {
            $this->add($user);
        }
    }
}
