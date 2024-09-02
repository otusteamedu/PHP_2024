<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\ResultSet;

use PDO;
use PDOStatement;

class ProxyResultSet extends AbstractResultSet
{
    /** @var array|null  */
    protected ?array $data = null;

    /**
     * @param PDOStatement $statement
     */
    public function __construct(
        readonly private PDOStatement $statement
    ) {
    }

    /**
     * @return array
     */
    protected function getData(): array
    {
        if (is_null($this->data)) {
            $this->statement->execute();
            $this->data = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return $this->data;
    }
}
