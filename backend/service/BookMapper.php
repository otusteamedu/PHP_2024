<?php

declare(strict_types=1);

namespace Service;

class BookMapper
{
    private \PDO $dbConnection;
    private array $identityMap = [];

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->dbConnection = $databaseConnection->getConnection();
    }

    public function find(int $id): ?Book
    {
        if (isset($this->identityMap[$id])) {
            return $this->identityMap[$id];
        }

        $statement = $this->dbConnection->prepare("SELECT * FROM books WHERE id = :id");
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $book = $this->mapRowToBook($row);
            $this->identityMap[$id] = $book;
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
            $bookId = (int)$row['id'];

            if (isset($this->identityMap[$bookId])) {
                $books[] = $this->identityMap[$bookId];
            } else {
                $book = $this->mapRowToBook($row);
                $this->identityMap[$bookId] = $book;
                $books[] = $book;
            }
        }

        return $books;
    }

    public function findAll(): array
    {
        $statement = $this->dbConnection->query("SELECT * FROM books");
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $books = [];

        foreach ($rows as $row) {
            $books[] = $this->mapRowToBook($row);
        }

        return $books;
    }

    public function save(Book $book): void
    {
        if ($book->getId()) {
            $this->update($book);
        } else {
            $this->insert($book);
        }
    }

    private function insert(Book $book): void
    {
        $statement = $this->dbConnection->prepare(
            "INSERT INTO books (name, author_id, date_of_issue, rating, number_of_copies) 
            VALUES (:name, :author_id, :date_of_issue, :rating, :number_of_copies)"
        );
        $statement->execute([
            'name' => $book->getName(),
            'author_id' => $book->getAuthorId(),
            'date_of_issue' => $book->getDateOfIssue()->format('Y-m-d'),
            'rating' => $book->getRating(),
            'number_of_copies' => $book->getNumberOfCopies()
        ]);
        $book->setId((int)$this->dbConnection->lastInsertId());
    }

    private function update(Book $book): void
    {
        $statement = $this->dbConnection->prepare(
            "UPDATE books SET name = :name, author_id = :author_id, date_of_issue = :date_of_issue, 
            rating = :rating, number_of_copies = :number_of_copies WHERE id = :id"
        );
        $statement->execute([
            'name' => $book->getName(),
            'author_id' => $book->getAuthorId(),
            'date_of_issue' => $book->getDateOfIssue()->format('Y-m-d'),
            'rating' => $book->getRating(),
            'number_of_copies' => $book->getNumberOfCopies(),
            'id' => $book->getId()
        ]);
    }

    private function mapRowToBook(array $row): Book
    {
        $book = new Book();
        $book->setId((int)$row['id']);
        $book->setName($row['name']);
        $book->setAuthorId((int)$row['author_id']);
        $book->setDateOfIssue(new \DateTimeImmutable($row['date_of_issue']));
        $book->setRating($row['rating'] !== null ? (float)$row['rating'] : null);
        $book->setNumberOfCopies((int)$row['number_of_copies']);
        return $book;
    }
}
