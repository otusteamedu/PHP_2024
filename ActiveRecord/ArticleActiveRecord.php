<?php

declare(strict_types=1);

namespace AKagirova\Hw17;

class ArticleActiveRecord
{
    private ?int $id = null;

    private PDO $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM article WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO article (title, text, author_id) VALUES (?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE article SET title = ?, text = ?, author_id = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM article WHERE id = ?'
        );
    }

    public function findOneById(int $id)
    {
        if (($article = ArticleIdentityMap::getArticle($id)) === true) {
            return $article;
        }
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        if ($this->selectStatement->rowCount() == 0) {
            throw new Exception('Нет статьи с id ' . $id);
        }
        $result = $this->selectStatement->fetch(PDO::FETCH_ASSOC);

        $article = new Article($result['title'], $result['text'], $result['author_id']);
        ArticleIdentityMap::addArticle($article, $id);

        return $article;
    }

    public function insert(Article $article): int
    {
        if (ArticleIdentityMap::getId($article) != false) {
            throw new Exception('Такая статлья уже существует');
        }
        $this->insertStatement->execute([
            $article->getTitle(),
            $article->getText(),
            $article->getAuthorId(),
        ]);

        $this->id = (int)$this->pdo->lastInsertId();
        ArticleIdentityMap::addArticle($article, $this->id);

        return $this->id;
    }

    public function update(Article $article): bool
    {
        if (($id = ArticleIdentityMap::getId($article)) == false) {
            throw new Exception('Нет статьи с id ' . $id);
        }
        return $this->updateStatement->execute([
            $article->getTitle(),
            $article->getText(),
            $article->getAuthorId(),
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        if (ArticleIdentityMap::getArticle($id) == false) {
            throw new Exception('Нет статьи с id ' . $id);
        }
        $this->deleteStatement->execute([$id]);
        if ($this->deleteStatement->rowCount() == 0) {
            return false;
        }

        return true;
    }
}
