<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Exceptions\UserNotFoundException;

interface UserRepository
{

    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findById(string $nickname): User;

    public function save(User $user): User;

    public function delete(User $user): void;
}
