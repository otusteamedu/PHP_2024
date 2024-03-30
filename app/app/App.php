<?php

declare(strict_types=1);

namespace Rmulyukov\Hw;

use Rmulyukov\Hw\Application\Event\Criteria;
use Rmulyukov\Hw\Application\Event\Event;
use Rmulyukov\Hw\Application\Factory\EventFactory;
use Rmulyukov\Hw\Application\Repository\EventCommandRepositoryInterface;
use Rmulyukov\Hw\Application\Repository\EventQueryRepositoryInterface;

final readonly class App
{
    public function __construct(
        private EventFactory $eventFactory,
        private EventCommandRepositoryInterface $commandRepository,
        private EventQueryRepositoryInterface $queryRepository,
    ) {
    }

    public function run(ConsoleParams $params): bool|array
    {
        return match ($params->getCommand()) {
            'add' => $this->commandRepository->add($this->prepareEvent($params)),
            'clear' => $this->commandRepository->clear(),
            'get' => $this->queryRepository->getByCriteria(...$this->prepareCriteria($params))->toArray(),
            default => ['result' => "Undefined or empty param"]
        };
    }

    private function prepareEvent(ConsoleParams $params): Event
    {
        $options = $params->getOptions();
        $id = (int) $options['id'] ?? 0;
        $priority = (int) $options['priority'] ?? 0;
        unset($options['id'], $options['priority']);
        return $this->eventFactory->create($id, $priority, $options);
    }

    private function prepareCriteria(ConsoleParams $params): array
    {
        $options = $params->getOptions();
        unset($options['id'], $options['priority']);
        return $this->eventFactory->createCriteria($options);
    }
}
