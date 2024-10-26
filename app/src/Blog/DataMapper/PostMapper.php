<?php

declare(strict_types=1);

namespace App\Blog\DataMapper;

use App\Blog\Model\Post;
use App\Shared\Model\Collection;
use App\Shared\Model\CollectionProxy;
use App\Shared\Utility\StringFormatter;
use Exception;
use PDO;
use PDOStatement;
use RuntimeException;
use UnitEnum;

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

    public function save(Post $post): Post
    {
        $statement = $post->isNew()
            ? $this->makeCreateStatement($post)
            : $this->makeUpdateStatement($post);

        if (null === $statement) {
            return $post;
        }

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

    private function makeUpdateStatement(Post $post): ?PDOStatement
    {
        $dirtyFields = array_keys($post->getDirtyFields());

        if (empty($dirtyFields)) {
            return null;
        }

        $query = 'UPDATE blog_posts SET ';

        foreach ($dirtyFields as $field) {
            $query .= $field . ' = :' . $field . ', ';
        }

        $query = rtrim($query, ', ') . ' WHERE id = :id';

        $statement = $this->pdo->prepare($query);

        foreach ($dirtyFields as $field) {
            $accessor = StringFormatter::fromSnakeCaseToCamelCase('get' . $field);

            $value = $post->{$accessor}();
            $value = match (true) {
                $value instanceof UnitEnum => $value->value,
                default => $value,
            };


            $statement->bindValue(':' . $field, $value);
        }

        $statement->bindValue(':id', $post->getId());

        $post->resetDirtyFields();

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
