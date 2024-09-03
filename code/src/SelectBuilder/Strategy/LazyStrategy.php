<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\Strategy;

use Iterator;
use PDOStatement;
use Viking311\Builder\SelectBuilder\ResultSet\ProxyResultSet;

class LazyStrategy implements StrategyInterface
{
    /**
     * @param PDOStatement $statement
     * @return Iterator
     */
    public function getResultSet(PDOStatement $statement): Iterator
    {
        return new ProxyResultSet($statement);
    }
}
