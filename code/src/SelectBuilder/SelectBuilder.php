<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder;

use PDO;
use Viking311\Builder\SelectBuilder\ResultSet\AbstractResultSet;
use Viking311\Builder\SelectBuilder\Strategy\StrategyInterface;

class SelectBuilder
{
    /** @var string  */
    private string $table;
    /** @var array  */
    private array $where = [];
    /** @var string|null  */
    private ?string $orderField = null;
    /** @var string  */
    private string $orderDirection;

    /**
     * @param PDO $db
     * @param StrategyInterface $strategy
     */
    public function __construct(
        readonly private PDO $db,
        readonly private StrategyInterface $strategy
    ) {
    }

    /**
     * @param string $table
     * @return $this
     */
    public function from(string $table): SelectBuilder
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @return $this
     */
    public function where(
        string $field,
        string $value
    ): SelectBuilder {
        $this->where[$field] = $value;

        return $this;
    }

    /**
     * @param string $field
     * @param string $direction
     * @return $this
     */
    public function orderBy(
        string $field,
        string $direction = 'asc'
    ): SelectBuilder {
        $this->orderField = $field;
        $this->orderDirection = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';

        return $this;
    }

    /**
     * @return AbstractResultSet
     */
    public function execute(): AbstractResultSet
    {
        $query = 'SELECT * FROM ' . $this->table;

        $query .= ' ' . $this->buildWhere();
        $query .= ' ' . $this->buildOrderBy();

        $statement = $this->db->prepare($query);

        return $this->strategy->getResultSet($statement);
    }

    /**
     * @return string
     */
    private function buildWhere(): string
    {
        $wheres = [];
        foreach ($this->where as $field => $value) {
            $wheres[] = $field . '=' . $value;
        }
        if (empty($wheres)) {
            return '';
        }

        return 'WHERE ' . implode(' AND ', $wheres);
    }

    /**
     * @return string
     */
    private function buildOrderBy(): string
    {
        if (!is_null($this->orderField)) {
            return "ORDER BY $this->orderField $this->orderDirection";
        }

        return '';
    }
}
