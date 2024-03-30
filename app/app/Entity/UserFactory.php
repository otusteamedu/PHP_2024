<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Entity;

use Exception;

final class UserFactory
{
    /**
     * @throws Exception
     */
    public function create(array $row): User
    {
        $this->ensureCorrectData($row);
        $user = new User($row['uuid'], $row['name'], $row['surname']);
        $user->setEmail($row['email'] ?? null);
        return $user;
    }

    /**
     * @throws Exception
     */
    public function createCollection(array $rows): UserCollection
    {
        $users = new UserCollection();
        foreach ($rows as $row) {
            $users->add($this->create($row));
        }
        return $users;
    }

    /**
     * @throws Exception
     */
    private function ensureCorrectData(array $raw): void
    {
        if (!isset($raw['uuid'], $raw['name'], $raw['surname'])) {
            throw new Exception(
                sprintf(
                    'Necessary data for user entity is uuid, name, surname, %s received',
                    implode(', ', $raw)
                )
            );
        }
    }
}
