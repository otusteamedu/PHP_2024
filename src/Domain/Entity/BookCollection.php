<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class BookCollection implements IteratorAggregate, Countable
{
    private array $books = [];

    public function add(Book $book): void
    {
        $this->books[] = $book;
    }

    public function remove(Book $book): void
    {
        $key = array_search($book, $this->books, true);
        if ($key !== false) {
            unset($this->books[$key]);
        }
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function count(): int
    {
        return count($this->books);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->books);
    }
}
