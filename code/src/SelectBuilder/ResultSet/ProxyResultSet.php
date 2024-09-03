<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\ResultSet;

use Iterator;
use PDO;
use PDOStatement;

class ProxyResultSet implements Iterator
{
    private ?ResultSet $resultSet = null;

    /**
     * @param PDOStatement $statement
     */
    public function __construct(
        readonly private PDOStatement $statement
    )
    {
    }

    /**
     * @return array
     */
    public function current(): array
    {
        return $this->getResultSet()->current();
    }

    /**
     * @return void
     */
    public function next(): void
    {
        $this->getResultSet()->next();
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->getResultSet()->key();
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return $this->getResultSet()->valid();
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->getResultSet()->rewind();
    }

    /**
     * @return ResultSet
     */
    private function getResultSet(): ResultSet
    {
        if (is_null($this->resultSet)) {
            $this->statement->execute();
            $this->resultSet = new ResultSet($this->statement->fetchAll(PDO::FETCH_ASSOC));
        }

        return $this->resultSet;
    }
}
