<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis;

use AlexanderPogorelov\Redis\Controller\SearchController;
use AlexanderPogorelov\Redis\Controller\SeedController;
use AlexanderPogorelov\Redis\Factory\EventFactory;
use AlexanderPogorelov\Redis\Repository\EventRedisRepository;

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
            'init' => [ new SeedController(new EventRedisRepository(), new EventFactory()), 'seedAction' ],
            'search' => [ new SearchController(new EventRedisRepository()), 'searchAction' ],
            default => throw new \InvalidArgumentException(sprintf('Invalid action: %s.', $action)),
        };

        $arguments = isset($this->argv[2]) ? array_slice($this->argv, 2) : [];

        return [
            'callback' => $callback,
            'arguments' => $arguments,
        ];
    }
}
