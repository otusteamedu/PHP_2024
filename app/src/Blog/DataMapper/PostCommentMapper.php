<?php

declare(strict_types=1);

namespace App\Blog\DataMapper;

use App\Blog\Model\PostComment;
use App\Shared\Model\Collection;
use PDO;

final readonly class PostCommentMapper
{
    public function __construct(
        private PDO $pdo,
    ) {}

    public function findByPostId(int $postId): Collection
    {
        $query = 'SELECT * FROM blog_post_comments WHERE post_id = :id';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $postId);
        $statement->execute();

        $data = $statement->fetchAll();

        if (false === $data) {
            return new Collection();
        }

        return new Collection(array_map(fn(array $data) => PostComment::fromArray($data), $data));
    }
}
