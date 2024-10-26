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

    public function findAll(): Collection
    {
        $query = 'SELECT * FROM blog_posts ORDER BY id';

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $rows = $statement->fetchAll();

        if (false === $rows) {
            return new Collection();
        }

        return new Collection(array_map([$this, 'makePostFromRow'], $rows));
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
