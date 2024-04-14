<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Controller;

use AlexanderPogorelov\Redis\Factory\EventFactory;
use AlexanderPogorelov\Redis\Repository\EventRepositoryInterface;
use AlexanderPogorelov\Redis\Response\Response;
use AlexanderPogorelov\Redis\Response\ResponseInterface;

readonly class SeedController
{
    public function __construct(private EventRepositoryInterface $repository, private EventFactory $factory)
    {
    }

    public function seedAction(): ResponseInterface
    {
        $this->repository->clearAll();
        $events = $this->factory->generateEvents();

        foreach ($events as $event) {
            $this->repository->add($event);
        }

        return new Response('Initialisation has been completed');
    }
}
