<?php

declare(strict_types=1);

namespace VladimirGrinko\ActiveRecord;

use PDO;
use PDOStatement;

class Movie
{
    private ?int $id = null;
    private ?string $name = null;
    private ?int $year = null;
    private ?float $rating = null;
    private ?int $duration = null;

    private PDO          $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $selectOneRandomStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM moviers WHERE id = ?'
        );
        $this->selectAllStatement = $pdo->prepare(
            'SELECT * FROM moviers LIMIT ?, ?'
        );
        $this->selectOneRandomStatement = $pdo->prepare(
            'SELECT * FROM moviers ORDER BY RAND() LIMIT 1'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO moviers (name, year, rating, duration) VALUES (?, ?, ?, ?)'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM moviers WHERE id = ?'
        );
    }

    private function updateStatement(): bool
    {
        $arParams = $arString = [];

        foreach (['name', 'year', 'rating', 'duration'] as $field) {
            if ($this->{$field} !== null) {
                $arParams[] = $this->{$field};
                $arString[] = $field . ' = ?';
            }
        }

        if (empty($arParams)) {
            throw new \Exception('Empty all fields');
        }

        return $this->pdo->prepare(
            'UPDATE moviers SET '. implode(', ', $arString) .' WHERE id = ?'
        )->execute($arParams);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function selectById(int $id): self
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setId((int)$this->pdo->lastInsertId())
            ->setName($result['name'])
            ->setYear($result['year'])
            ->setRating($result['rating'])
            ->setDuration($result['duration']);
    }

    public function selectAll(int $page = 0, int $limit = 1000): MovieCollection
    {
        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute([$page, $limit]);

        $result = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);

        $collection = new MovieCollection();
        foreach ($result as $resItem) {
            $collection->offsetSet(
                $resItem['id'],
                (new self($this->pdo))
                    ->setId($resItem['id'])
                    ->setName($resItem['name'])
                    ->setYear($resItem['year'])
                    ->setRating($resItem['rating'])
                    ->setDuration($resItem['duration'])
            );
        }

        return $collection;
    }

    public function selectOneRandom(): self
    {
        $this->selectOneRandomStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectOneRandomStatement->execute();

        $result = $this->selectOneRandomStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setId((int)$this->pdo->lastInsertId())
            ->setName($result['name'])
            ->setYear($result['year'])
            ->setRating($result['rating'])
            ->setDuration($result['duration']);
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->name,
            $this->year,
            $this->rating,
            $this->duration,
        ]);

        $this->id = (int)$this->pdo->lastInsertId();
        return $this->id;
    }

    public function update(): bool
    {
        return $this->updateStatement();
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStatement->execute([$id]);

        $this->id = null;
        return $result;
    }
}
