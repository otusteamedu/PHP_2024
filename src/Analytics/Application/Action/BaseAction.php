<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Action;

use AlexanderGladkov\Analytics\Repository\EventRepositoryInterface;

abstract class BaseAction
{
    public function __construct(protected readonly EventRepositoryInterface $eventRepository)
    {
    }

    abstract public function run(array $args = []): Response;
}
