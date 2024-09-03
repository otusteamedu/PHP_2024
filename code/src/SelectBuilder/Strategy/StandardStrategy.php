<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\Strategy;

use Iterator;
use PDO;
use PDOStatement;
use Viking311\Builder\SelectBuilder\ResultSet\ResultSet;

class StandardStrategy implements StrategyInterface
{
    /**
     * @param PDOStatement $statement
     * @return Iterator
     */
    public function getResultSet(PDOStatement $statement): Iterator
    {
        $statement->execute();
        return new ResultSet(
            $statement->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}
