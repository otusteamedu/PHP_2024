<?php

declare(strict_types=1);

namespace App\Blog\DataMapper;

use App\Blog\Model\Post;
use App\Shared\Model\Collection;
use App\Shared\Model\CollectionProxy;
use Exception;
use PDO;
use PDOStatement;
use RuntimeException;

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
        $query = 'SELECT * FROM blog_posts';

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $rows = $statement->fetchAll();

        if (false === $rows) {
            return new Collection();
        }

        return new Collection(array_map([$this, 'makePostFromRow'], $rows));
    }

    public function save(Post $post): Post
    {
        $statement = $post->isNew()
            ? $this->makeCreateStatement($post)
            : $this->makeUpdateStatement($post);

        try {
            $statement->execute();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage(), previous: $e);
        }

        if ($post->isNew()) {
            $post->setId((int) $this->pdo->lastInsertId());
        }

        return $post;
    }

    private function makeCreateStatement(Post $post): PDOStatement
    {
        $query = 'INSERT INTO blog_posts(title, content, status) VALUES(:title, :content, :status)';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':title', $post->getTitle());
        $statement->bindValue(':content', $post->getContent());
        $statement->bindValue(':status', $post->getStatus()->value);

        return $statement;
    }

    private function makeUpdateStatement(Post $post): PDOStatement
    {
        $query = 'UPDATE blog_posts SET title = :title, content = :content, status = :status WHERE id = :id';

        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $post->getId());
        $statement->bindValue(':title', $post->getTitle());
        $statement->bindValue(':content', $post->getContent());
        $statement->bindValue(':status', $post->getStatus()->value);

        return $statement;
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
