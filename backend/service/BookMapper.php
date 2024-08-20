<?php

namespace Service;

class BookMapper
{
    private \PDO $dbConnection;
    private array $identityMap = [];

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->dbConnection = $databaseConnection->getConnection();
    }

    public function find($id): ?Book
    {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $statement = $this->dbConnection->prepare("SELECT * FROM books WHERE id = :id");
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $book = $this->mapRowToBook($row);
            $this->identityMap[$id] = $book; // Добавляем книгу в Identity Map
            return $book;
        }

        return null;
    }

    public function findAllByAuthorId(int $authorId): array
    {
        $statement = $this->dbConnection->prepare("SELECT * FROM books WHERE author_id = :author_id");
        $statement->execute(['author_id' => $authorId]);
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $books = [];
        foreach ($rows as $row) {
            $bookId = $row['id'];

            if (isset($this->identityMap[$bookId])) {
                $books[] = $this->identityMap[$bookId];
            } else {
                $book = $this->mapRowToBook($row);
                $this->identityMap[$bookId] = $book; // Добавляем книгу в Identity Map
                $books[] = $book;
            }
        }

        return $books;
    }

    public function findAll() {
        $statement = $this->dbConnection->query("SELECT * FROM books");
        $rows = $statement->fetchAll();
        $books = [];

        foreach ($rows as $row) {
            $books[] = $this->mapRowToBook($row);
        }

        return $books;
    }

    public function save(Book $book) {
        if ($book->getId()) {
            $this->update($book);
        } else {
            $this->insert($book);
        }
    }

    private function insert(Book $book) {
        $statement = $this->dbConnection->prepare(
            "INSERT INTO books (name, author_id, date_of_issue, rating, number_of_copies) 
            VALUES (?, ?, ?, ?, ?)"
        );
        $statement->execute([
            $book->getName(),
            $book->getAuthorId(),
            $book->getDateOfIssue(),
            $book->getRating(),
            $book->getNumberOfCopies()
        ]);
        $book->setId($this->dbConnection->lastInsertId());
    }

    private function update(Book $book) {
        $statement = $this->dbConnection->prepare(
            "UPDATE books SET name = ?, author_id = ?, date_of_issue = ?, rating = ?, number_of_copies = ? WHERE id = ?"
        );
        $statement->execute([
            $book->getName(),
            $book->getAuthorId(),
            $book->getDateOfIssue(),
            $book->getRating(),
            $book->getNumberOfCopies(),
            $book->getId()
        ]);
    }

    private function mapRowToBook($row) {
        $book = new Book();
        $book->setId($row['id']);
        $book->setName($row['name']);
        $book->setAuthorId($row['author_id']);
        $book->setDateOfIssue($row['date_of_issue']);
        $book->setRating($row['rating']);
        $book->setNumberOfCopies($row['number_of_copies']);
        return $book;
    }
}
