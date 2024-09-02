<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\Strategy;

use PDOStatement;
use Viking311\Builder\SelectBuilder\ResultSet\AbstractResultSet;
use Viking311\Builder\SelectBuilder\ResultSet\ProxyResultSet;

class LazyStrategy implements StrategyInterface
{
    /**
     * @param PDOStatement $statement
     * @return AbstractResultSet
     */
    public function getResultSet(PDOStatement $statement): AbstractResultSet
    {
        return new ProxyResultSet($statement);
    }
}
