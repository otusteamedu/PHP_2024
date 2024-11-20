<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch;

use AlexanderPogorelov\ElasticSearch\Controller\DataController;
use AlexanderPogorelov\ElasticSearch\Controller\SearchController;

readonly class Resolver
{
    public function __construct(private array $argv)
    {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function run(): array
    {
        $action = $this->argv[1] ?? null;

        $callback = match ($action) {
            'init' => [ new DataController(), 'initAction' ],
            'get' => [ new DataController(), 'getByIdAction' ],
            'create' => [ new DataController(), 'addWithIdAction' ],
            'all' => [ new DataController(), 'searchAllAction' ],
            'title' => [ new DataController(), 'searchByTitleAction' ],
            'category' => [ new DataController(), 'searchByCategoryAction' ],
            'mapping' => [ new DataController(), 'getMappingAction' ],
            'search' => [ new SearchController(), 'searchAction' ],
            default => throw new \InvalidArgumentException(sprintf('Invalid action: %s.', $action)),
        };

        $arguments = isset($this->argv[2]) ? array_slice($this->argv, 2) : [];

        return [
            'callback' => $callback,
            'arguments' => $arguments,
        ];
    }
}
