<?php

namespace App\Infrastructure\QueryBuilder;

use App\Application\Event\QueryBuilder\SqlIsExecutedEvent;
use App\Application\Publisher\QueryBuilder\PublisherInterface;
use App\Domain\SelectQuery\DatabaseQueryResult;
use App\Domain\Service\ConfigService;
use Iterator;
use PDO;
use PDOStatement;
use stdClass;

class DatabaseQueryResultProxy extends DatabaseQueryResult implements Iterator
{
    private ?array $collection = null;
    private int $position = 0;
    private string $query;

    private PDO $pdo;

    public function __construct(string $query, private readonly PublisherInterface $publisher)
    {
        parent::__construct([], $publisher);
        $this->query = $query;

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

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    public function current(): stdClass
    {
        return $this->collection[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function valid(): bool
    {
        if ($this->collection === null) {
            $this->setCollection($this->execute());
        }

        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    private function setCollection(array $queryResult): void
    {
        foreach ($queryResult as $item) {
            $object = new stdClass();
            foreach ($item as $key => $value) {
                $object->$key = $value;
            }
            $this->collection[] = $object;
        }
    }

    private function execute(): array
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare($this->query);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $queryResult = $stmt->fetchAll();

        $event = new SqlIsExecutedEvent(
            'SqlIsExecutedEvent',
            get_class($this),
            $this->query,
            $queryResult
        );
        $this->publisher->notify($event);

        return $queryResult;
    }
}
