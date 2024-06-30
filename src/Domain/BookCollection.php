<?php

declare(strict_types=1);

namespace Main\Infrastructure;

use Main\Infrastructure\Book;

/**
 * Class BookCollection
 * @property array $books;
 */
class BookCollection implements IteratorAggregate, Countable
{

    private $books;

    /**
     * @param array $books Array of Book objects.
     */
    public function __construct(array $books = [])
    {
        foreach ($books as $book) {
            if (!$book instanceof Book) {
                throw new InvalidArgumentException('BookCollection can only contain Book objects.');
            }
        }
        $this->books = $books;
    }

    /**
     * @param Book $book The Book object to add.
     */
    public function add(Book $book): void
    {
        $this->books[] = $book;
    }

    /**
     * @return ArrayIterator An iterator for the collection.
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->books);
    }

    /**
     * @return int The number of books in the collection.
     */
    public function count(): int
    {
        return count($this->books);
    }

    /**
     * @param array $bookDataArray Array containing book data arrays.
     * @return BookCollection
     */
    public static function getInstanceFromArray(array $bookDataArray): self
    {
        $books = [];
        foreach ($bookDataArray as $bookData) {
            // Assuming $bookData is an associative array containing book information
            $books[] = new Book(
                $bookData['title'],
                $bookData['sku'],
                $bookData['category'],
                $bookData['price'],
                $bookData['stock']
            );
        }
        return new self($books);
    }
}