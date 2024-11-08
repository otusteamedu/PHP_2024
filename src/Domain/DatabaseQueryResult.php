<?php

namespace App\Application\QueryBuilder;

use App\Application\QueryBuilder\Event\DatabaseQueryResultIsCreatedEvent;
use App\Application\QueryBuilder\Publisher\PublisherInterface;
use Iterator;
use stdClass;

class DatabaseQueryResult implements Iterator
{
    private array $collection;
    private int $position = 0;

    public function __construct(?array $queryResult, private readonly PublisherInterface $publisher)
    {
        $this->getQueryResult($queryResult);
        $event = new DatabaseQueryResultIsCreatedEvent(
            'DatabaseQueryResultIsCreatedEvent',
            get_class($this),
            null,
            count($queryResult) > 0 ? $queryResult : null
        );
        $this->publisher->notify($event);
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
        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function getQueryResult(array $queryResult): void
    {
        foreach ($queryResult as $item) {
            $object = new stdClass();
            foreach ($item as $key => $value) {
                $object->$key = $value;
            }
            $this->collection[] =  $object;
        }
    }
}
