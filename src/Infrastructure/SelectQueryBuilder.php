<?php

namespace App\Application\QueryBuilder;

use App\Application\QueryBuilder\Publisher\PublisherInterface;
use App\Domain\Service\ConfigService;
use PDO;
use PDOStatement;

class SelectQueryBuilder implements SelectQueryBuilderInterface
{
    public string $query;
    public string $select;
    /** @var string[] $where */
    public ?array $where;
    public ?string $limit;
    public ?string $order;

    private PDO $pdo;

    public function __construct(private readonly PublisherInterface $publisher)
    {
        $config = ConfigService::class;
        $host =  $config::get('POSTGRES_CONTAINER_NAME');
        $db =  $config::get('POSTGRES_DB');

        $this->pdo = new PDO(
            "pgsql:host=$host;port=5432;dbname=$db;",
            $config::get('POSTGRES_USER'),
            $config::get('POSTGRES_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function from(string $table): self
    {
        $this->select = 'SELECT * FROM ' . $table;

        return $this;
    }

    public function where(string $field, string|int $value, string $operator = '='): self
    {
        $this->where[] = $field . $operator . (gettype($value) === 'string' ? "'$value'" : $value);

        return $this;
    }

    public function orderBy(string $field, string $direction = 'DESC'): self
    {
        $this->order = ' ORDER BY ' . $field . ' ' . $direction;

        return $this;
    }

    public function limit(int $limit, int $offset = 0): self
    {
        $this->limit = " LIMIT " . $limit . " OFFSET " . $offset;

        return $this;
    }

    public function execute(bool $lazy = true): DatabaseQueryResult
    {
        if ($lazy) {
            return new DatabaseQueryResultProxy($this->getQuery(), $this->publisher);
        }

        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare($this->getQuery());
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        return new DatabaseQueryResult($stmt->fetchAll(), $this->publisher);
    }

    private function getQuery(): string
    {
        $this->query = $this->select;

        if (!empty($this->where)) {
            $this->query .= ' WHERE ' . implode(' AND ', $this->where);
        }

        if (isset($this->order)) {
            $this->query .= $this->order;
        }

        if (isset($this->limit)) {
            $this->query .= $this->limit;
        }

        return $this->query .= ";";
    }
}
