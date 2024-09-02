<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder\ResultSet;

use PDO;
use PDOStatement;

class ProxyResultSet extends AbstractResultSet
{
    protected ?array $data = null;

    public function __construct(
        readonly private PDOStatement $statement
    )
    {
    }

    protected function getData(): array
    {
        if (is_null($this->data)) {
            $this->statement->execute();
            $this->data = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return $this->data;
    }
}
