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

    public function saveManyByPostId(int $postId, Collection $collection): Collection
    {
        $this->makeCreateStatement($collection);
    }

    private function makeCreateStatement(Collection $collection): PDOStatement
    {
        $query = 'INSERT INTO blog_posts(title, content, status) VALUES ';

        for ($i = 0; $i < $collection->count(); $i++) {
            $query .= "(:post_id_$i, :content_$i), ";
        }

        $query = rtrim($query, ' ,');

        $statement = $this->pdo->prepare($query);

        foreach ($collection->all() as $comment) {
            $statement->bindValue(':post_id_' . $i, $comment->getPostId());
        }

        $statement->bindValue(':title', $post->getTitle());
        $statement->bindValue(':content', $post->getContent());
        $statement->bindValue(':status', $post->getStatus()->value);

        return $statement;
    }
}
