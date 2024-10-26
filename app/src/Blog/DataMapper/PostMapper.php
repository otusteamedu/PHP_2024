<?php

declare(strict_types=1);

namespace App\Blog\DataMapper;

use App\Blog\Model\Post;
use App\Shared\Model\Collection;
use App\Shared\Model\CollectionProxy;
use PDO;

final readonly class PostMapper
{
    public function __construct(
        private PDO $pdo,
        private PostCommentMapper $postCommentMapper,
    ) {}

    public function findById(int $id): ?Post
    {
        $query = 'SELECT * FROM blog_posts WHERE id = :id';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $row = $statement->fetch();

        if (false === $row) {
            return null;
        }

        return $this->makePostFromRow($row);
    }

    public function findAll(?int $pageSize = null, int $pageNumber = 1): Collection
    {
        $query = 'SELECT * FROM blog_posts ORDER BY id';

        if ($pageSize) {
            $query .= ' LIMIT ' . $pageSize;
        }

        if ($pageSize && $pageNumber) {
            $query .= ' OFFSET ' . $pageSize * ($pageNumber - 1);
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $rows = $statement->fetchAll();

        if (false === $rows) {
            return new Collection();
        }

        return new Collection(array_map([$this, 'makePostFromRow'], $rows));
    }

    public function count(): int
    {
        $query = 'SELECT COUNT(id) FROM blog_posts';

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return (int) $statement->fetchColumn();
    }

    private function makePostFromRow(array $row): Post
    {
        $post = Post::fromArray($row);
        $post->setComments($this->makePostCommentCollection($post->getId()));

        return $post;
    }

    private function makePostCommentCollection(int $id): Collection
    {
        return new CollectionProxy(fn() => $this->postCommentMapper->findByPostId($id)->all());
    }
}
