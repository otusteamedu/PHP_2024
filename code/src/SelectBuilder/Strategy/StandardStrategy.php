<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\Strategy;

use PDO;
use PDOStatement;
use Viking311\Builder\SelectBuilder\ResultSet\AbstractResultSet;
use Viking311\Builder\SelectBuilder\ResultSet\ResultSet;

class StandardStrategy implements StrategyInterface
{
    /**
     * @param PDOStatement $statement
     * @return AbstractResultSet
     *
     */
    public function getResultSet(PDOStatement $statement): AbstractResultSet
    {
        $statement->execute();
        return new ResultSet(
            $statement->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}
