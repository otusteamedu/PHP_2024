<?php

declare(strict_types=1);

namespace Service;

class AuthorMapper
{
    private \PDO $dbConnection;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->dbConnection = $databaseConnection->getConnection();
    }

    public function find(int $id): ?Author
    {
        $statement = $this->dbConnection->prepare("SELECT * FROM authors WHERE id = ?");
        $statement->execute([$id]);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToAuthor($row) : null;
    }

    public function findAll(): array
    {
        $statement = $this->dbConnection->query("SELECT * FROM authors");
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $authors = [];

        foreach ($rows as $row) {
            $authors[] = $this->mapRowToAuthor($row);
        }

        return $authors;
    }

    public function save(Author $author): void
    {
        if ($author->getId()) {
            $this->update($author);
        } else {
            $this->insert($author);
        }
    }

    private function insert(Author $author): void
    {
        $statement = $this->dbConnection->prepare(
            "INSERT INTO authors (name, last_name, patronymic, date_of_birth, date_of_death, country, gender) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $statement->execute([
            $author->getName(),
            $author->getLastName(),
            $author->getPatronymic(),
            $author->getDateOfBirth()->format('Y-m-d'),
            $author->getDateOfDeath()?->format('Y-m-d'),
            $author->getCountry(),
            $author->getGender()
        ]);
        $author->setId((int)$this->dbConnection->lastInsertId());
    }

    private function update(Author $author): void
    {
        $statement = $this->dbConnection->prepare(
            "UPDATE authors SET name = ?, last_name = ?, patronymic = ?, date_of_birth = ?, date_of_death = ?, country = ?, gender = ? WHERE id = ?"
        );
        $statement->execute([
            $author->getName(),
            $author->getLastName(),
            $author->getPatronymic(),
            $author->getDateOfBirth()->format('Y-m-d'),
            $author->getDateOfDeath()?->format('Y-m-d'),
            $author->getCountry(),
            $author->getGender(),
            $author->getId()
        ]);
    }

    private function mapRowToAuthor(array $row): Author
    {
        $author = new Author();
        $author->setId((int)$row['id']);
        $author->setName($row['name']);
        $author->setLastName($row['last_name']);
        $author->setPatronymic($row['patronymic']);
        $author->setDateOfBirth(new \DateTimeImmutable($row['date_of_birth']));
        $author->setDateOfDeath($row['date_of_death'] ? new \DateTimeImmutable($row['date_of_death']) : null);
        $author->setCountry($row['country']);
        $author->setGender($row['gender']);

        return $author;
    }
}
