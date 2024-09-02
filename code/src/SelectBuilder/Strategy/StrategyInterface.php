<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\Strategy;

use PDOStatement;
use Viking311\Builder\SelectBuilder\ResultSet\AbstractResultSet;

interface StrategyInterface
{
    /**
     * @param PDOStatement $statement
     * @return AbstractResultSet
     */
    public function getResultSet(PDOStatement $statement): AbstractResultSet;
}
