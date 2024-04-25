<?php

namespace AKornienko\Php2024\DataMapper;

use PDO;
use PDOStatement;

class PostMapper
{
    private PDO $pdo;
    private PDOStatement $getPostsByUserIdStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->getPostsByUserIdStatement = $pdo->prepare(
            'SELECT * FROM posts WHERE user_id = ?'
        );
    }

    public function findByUserId(int $userId): array
    {
        $this->getPostsByUserIdStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->getPostsByUserIdStatement->execute([$userId]);

        $result = $this->getPostsByUserIdStatement->fetchAll();
        $posts = [];
        foreach ($result as $postRow) {
            $post = new Post($postRow['id'], $postRow['user_id'], $postRow['content']);
            $posts[] = $post;
        }
        return $posts;
    }
}
