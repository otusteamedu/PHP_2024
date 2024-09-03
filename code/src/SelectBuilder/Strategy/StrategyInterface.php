<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\Strategy;

use Iterator;
use PDOStatement;

interface StrategyInterface
{
    /**
     * @param PDOStatement $statement
     * @return Iterator
     */
    public function getResultSet(PDOStatement $statement): Iterator;
}
