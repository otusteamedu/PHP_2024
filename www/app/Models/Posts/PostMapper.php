<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Posts;

use Hukimato\App\Models\Users\UserMapper;
use PDO;
use PDOStatement;
use ReflectionException;

class PostMapper
{
    const TABLE_NAME = 'posts';
    const CLASS_NAME = Post::class;

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
            "SELECT * FROM " . self::TABLE_NAME . " WHERE id =?"
        );
        $this->insertStatement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE_NAME . " (title, content, user_username) VALUES (?,?,?)"
        );
        $this->updateStatement = $this->pdo->prepare(
            "UPDATE " . self::TABLE_NAME . " SET title =?, content =? WHERE id =?"
        );
        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM " . self::TABLE_NAME . " WHERE id =?"
        );
    }


    public function findOne(int $id): Post
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new Post(
            $result['title'],
            $result['content'],
            function () use ($result) {
                return (new UserMapper($this->pdo))->findOne($result['user_username']);
            },
            $id,
        );
    }

    public function insert(string $username, Post $post): Post
    {
        $this->insertStatement->execute([
            $post->title,
            $post->content,
            $username
        ]);

        return new Post(
            $post->title,
            $post->content,
            (new UserMapper($this->pdo))->findOne($username),
            (int)$this->pdo->lastInsertId(),
        );
    }

    public function update(Post $post): bool
    {
        return $this->updateStatement->execute([
            $post->title,
            $post->content,
            $post->id,
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->deleteStatement->execute([$id]);
    }

    public function findAllByUser(string $username): array
    {
        $query = $this->pdo->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE user_username =?");
        $query->execute([$username]);
        $result = $query->fetchAll();

        $posts = [];
        foreach ($result as $post) {
            $posts[] = new Post(
                $post['title'],
                $post['content'],
                function () use ($post) {
                    return (new UserMapper($this->pdo))->findOne($post['user_username']);
                },
                $post['id']);
        }

        return $posts;
    }
}
