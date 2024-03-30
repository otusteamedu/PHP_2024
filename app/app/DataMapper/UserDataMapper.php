<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\DataMapper;

use Exception;
use PDO;
use PDOStatement;
use Rmulyukov\Hw\Entity\User;
use Rmulyukov\Hw\Entity\UserCollection;
use Rmulyukov\Hw\Entity\UserFactory;
use Rmulyukov\Hw\IdentityMap\UserIdentityMap;

use function array_diff;
use function array_fill;
use function array_keys;
use function count;
use function implode;
use function sprintf;

final readonly class UserDataMapper
{
    private PDOStatement $selectOne;
    private string $selectAllQuery;
    private PDOStatement $insert;
    private PDOStatement $update;

    public function __construct(
        private PDO $pdo,
        private UserFactory $factory,
        private ?UserIdentityMap $identityMap = null
    ) {
        $this->selectOne = $this->pdo->prepare('SELECT * FROM users WHERE uuid = ?');
        $this->selectAllQuery = 'SELECT * FROM users WHERE uuid IN';
        $this->update = $this->pdo->prepare('UPDATE users SET name = ?, surname = ?, email = ? WHERE uuid = ?');
        $this->insert = $this->pdo->prepare('INSERT INTO users (uuid, name, surname, email) VALUES (?, ?, ?, ?)');
    }

    /**
     * @throws Exception
     */
    public function getOne(string $uuid): User
    {
        if ($user = $this->identityMap?->get($uuid)) {
            return $user;
        }

        $this->selectOne->execute([$uuid]);
        $row = $this->selectOne->fetch();
        $user = $this->factory->create($row);
        $this->identityMap?->add($user);

        return $user;
    }

    /**
     * @throws Exception
     */
    public function getAll(string $uuid, string ...$uuids): UserCollection
    {
        $uuids[] = $uuid;
        $users = [];
        foreach ($uuids as $uuid) {
            if ($user = $this->identityMap?->get($uuid)) {
                $users[$user->getUuid()] = $user;
            }
        }
        $difference = array_diff($uuids, array_keys($users));
        if (empty($difference)) {
            return new UserCollection(...$users);
        }

        $statement = $this->prepareSelectAllStatement(...$difference);
        $statement->execute($difference);
        $rows = $statement->fetchAll();
        $usersCollection = $this->factory->createCollection($rows);
        $this->identityMap?->addCollection($usersCollection);
        $usersCollection->addAll(...$users);

        return $usersCollection;
    }

    public function create(User $user): void
    {
        $this->insert->execute([$user->getUuid(), $user->getName(), $user->getSurname(), $user->getEmail()]);
        $this->identityMap?->add($user);
    }

    public function update(User $user): void
    {
        $this->update->execute([$user->getName(), $user->getSurname(), $user->getEmail(), $user->getUuid()]);
    }

    private function prepareSelectAllStatement(string ...$uuids): PDOStatement
    {
        $filler = implode(', ', array_fill(0, count($uuids), '?'));
        return $this->pdo->prepare(
            sprintf("%s (%s)", $this->selectAllQuery, $filler)
        );
    }
}
