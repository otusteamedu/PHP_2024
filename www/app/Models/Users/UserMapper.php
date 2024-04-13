<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Users;

use Exception;
use Hukimato\App\Models\Posts\PostMapper;
use PDO;
use PDOStatement;
use ReflectionException;

class UserMapper
{
    const TABLE_NAME = 'users';
    const CLASS_NAME = User::class;

    protected PDO $pdo;

    protected PDOStatement $selectStatement;

    protected PDOStatement $insertStatement;

    protected PDOStatement $updateStatement;

    protected PDOStatement $deleteStatement;

    /**
     * @throws ReflectionException
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $this->pdo->prepare(
            "SELECT * FROM " . self::TABLE_NAME . " WHERE username =?"
        );
        $this->insertStatement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE_NAME . " (username, email) VALUES (?,?)"
        );
        $this->updateStatement = $this->pdo->prepare(
            "UPDATE " . self::TABLE_NAME . " SET email =?, username=? WHERE username =?"
        );
        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM " . self::TABLE_NAME . " WHERE username =?"
        );
    }


    public function findOne(string $username)
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$username]);

        $result = $this->selectStatement->fetch();
        if ($result === false) {
            http_response_code(404);
            throw new Exception("Not found");
        }

        return new User(
            $result['username'],
            $result['email'],
            function () use ($result) {
                $query = 'SELECT friend FROM user_to_friends WHERE username = ' . $result['username'];
                $friendUsernames = $this->pdo->query($query)->fetchAll();

                $friends = [];
                $userMapper = new UserMapper($this->pdo);
                foreach ($friendUsernames as $friendUsername) {
                    $friends[] = $userMapper->findOne($$friendUsername['username']);
                }
                return $friends;
            },
            function () use ($result) {
                $query = "SELECT id FROM " . PostMapper::TABLE_NAME . " WHERE user = " . $result['username'];
                $postIds = $this->pdo->query($query)->fetchAll();

                $posts = [];
                $postMapper = new PostMapper($this->pdo);
                foreach ($postIds as $postId) {
                    $posts[] = $postMapper->findOne($postId['id']);
                }
                return $posts;
            }
        );
    }

    public function insert(User $user)
    {
        $this->pdo->beginTransaction();

        $this->insertStatement->execute([
            $user->username,
            $user->email,
        ]);

        return $this->pdo->commit();
    }

    public function update(string $username, User $user)
    {
        $this->pdo->beginTransaction();

        $this->updateStatement->execute([
            $user->email,
            $user->username,
            $username,
        ]);

        return $this->pdo->commit();
    }

    public function delete(string $username)
    {
        $this->pdo->beginTransaction();
        $query = $this->pdo->prepare('DELETE FROM user_to_friends WHERE username =? OR friend_username =?');
        $query->execute([$username, $username]);

        $query = $this->pdo->prepare('DELETE FROM ' . PostMapper::TABLE_NAME . ' WHERE user_username =?');
        $query->execute([$username]);

        $this->deleteStatement->execute([$username]);

        return $this->pdo->commit();
    }

    /**
     * @param User $user
     * @param User[] $friends
     */
    protected function updateFriends(User $user, array $friends)
    {
        $newFriendsList = array_map(function (User $friend) {
            return $friend->username;
        }, $friends);

        $this->pdo->beginTransaction();

        $currentFriendList = $this->pdo->query("SELECT friend FROM user_to_friends WHERE username = " . $user->username)->fetchAll();
        $currentFriendList = array_column($currentFriendList, 'friend');

        $friendsToDelete = array_diff($currentFriendList, $newFriendsList);
        $friendsToAdd = array_diff($newFriendsList, $currentFriendList);

        foreach ($friendsToDelete as $friendToDelete) {
            $this->pdo->prepare("DELETE FROM user_to_friends WHERE username =? AND friend_username =?")->execute([$user->username, $friendToDelete]);
        }

        foreach ($friendsToAdd as $friendToAdd) {
            $this->pdo->prepare("INSERT INTO user_to_friends (username, friend_username) VALUES (?,?)")->execute([$user->username, $friendToAdd]);
        }


        $this->pdo->commit();
    }
}
