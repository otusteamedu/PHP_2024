<?php

namespace AKornienko\Php2024\DataMapper;

use PDO;
use PDOStatement;

class UserMapper
{
    private PDO $pdo;

    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;
    private PDOStatement $selectAllStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectAllStatement = $pdo->prepare(
            'SELECT * FROM users'
        );
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO users (first_name, last_name, email) VALUES (?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM users WHERE id = ?'
        );
    }

    public function selectAll(): array
    {
        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute();

        $result = $this->selectAllStatement->fetchAll();
        $users = [];
        foreach ($result as $userRow) {
            $user = new User($userRow['id'], $userRow['first_name'], $userRow['last_name'], $userRow['birthdate']);
            $users[] = $user;
        }
        return $users;
    }

    public function findById(int $id): User
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new User(
            $result['id'],
            $result['first_name'],
            $result['last_name'],
            $result['birthdate'],
        );
    }

    public function insert(array $rawUserData): User
    {
        $this->insertStatement->execute([
            $rawUserData['first_name'],
            $rawUserData['last_name'],
            $rawUserData['email'],
        ]);

        return new User(
            (int)$this->pdo->lastInsertId(),
            $rawUserData['first_name'],
            $rawUserData['last_name'],
            $rawUserData['email'],
        );
    }

    public function update(User $user): bool
    {
        return $this->updateStatement->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getId(),
        ]);
    }

    public function delete(User $user): bool
    {
        return $this->deleteStatement->execute([$user->getId()]);
    }

    public function getPosts(User $user): array
    {
        if ($user->getPosts() == null) {
            $user = $this->directLoadPosts($user);
        }

        return $user->getPosts();
    }

    private function directLoadPosts(User $user): User
    {
        $postMapper = new PostMapper($this->pdo);
        $posts = $postMapper->findByUserId($user->getId());
        $user->setPosts($posts);
        return $user;
    }
}
