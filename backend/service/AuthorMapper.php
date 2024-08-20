<?php

namespace Service;

class AuthorMapper
{
    private \PDO $dbConnection;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->dbConnection = $databaseConnection->getConnection();
    }

    public function find($id) {
        $statement = $this->dbConnection->prepare("SELECT * FROM authors WHERE id = ?");
        $statement->execute([$id]);
        $row = $statement->fetch();

        return $this->mapRowToAuthor($row);
    }

    public function findAll() {
        $statement = $this->dbConnection->query("SELECT * FROM authors");
        $rows = $statement->fetchAll();
        $authors = [];

        foreach ($rows as $row) {
            $authors[] = $this->mapRowToAuthor($row);
        }

        return $authors;
    }

    public function save(Author $author) {
        if ($author->getId()) {
            $this->update($author);
        } else {
            $this->insert($author);
        }
    }

    private function insert(Author $author) {
        $statement = $this->dbConnection->prepare(
            "INSERT INTO authors (name, last_name, patronymic, date_of_birth, date_of_death, country, gender) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $statement->execute([
            $author->getName(),
            $author->getLastName(),
            $author->getPatronymic(),
            $author->getDateOfBirth(),
            $author->getDateOfDeath(),
            $author->getCountry(),
            $author->getGender()
        ]);
        $author->setId($this->dbConnection->lastInsertId());
    }

    private function update(Author $author) {
        $statement = $this->dbConnection->prepare(
            "UPDATE authors SET name = ?, last_name = ?, patronymic = ?, date_of_birth = ?, date_of_death = ?, country = ?, gender = ? WHERE id = ?"
        );
        $statement->execute([
            $author->getName(),
            $author->getLastName(),
            $author->getPatronymic(),
            $author->getDateOfBirth(),
            $author->getDateOfDeath(),
            $author->getCountry(),
            $author->getGender(),
            $author->getId()
        ]);
    }

    private function mapRowToAuthor($row) {
        $author = new Author();
        $author->setId($row['id']);
        $author->setName($row['name']);
        $author->setLastName($row['last_name']);
        $author->setPatronymic($row['patronymic']);
        $author->setDateOfBirth($row['date_of_birth']);
        $author->setDateOfDeath($row['date_of_death']);
        $author->setCountry($row['country']);
        $author->setGender($row['gender']);
        return $author;
    }
}
