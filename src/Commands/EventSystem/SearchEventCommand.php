<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\EventSystem;

use DI\DependencyException;
use DI\NotFoundException;
use RailMukhametshin\Hw\Commands\AbstractCommand;
use RailMukhametshin\Hw\Repositories\EventSystem\EventRepositoryInterface;
use RailMukhametshin\Hw\Traits\ConditionParsableTrait;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SearchEventCommand extends AbstractCommand
{
    use ConditionParsableTrait;

    /**
     * @throws UnknownProperties
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function execute(): void
    {
        $repository = $this->container->get(EventRepositoryInterface::class);
        $params = $this->parseAndGetParams();
        $item = $repository->getByParams($params);
        if ($item !== null) {
            $this->formatter->output($item->event->name);
        } else {
            $this->formatter->output('Event not found');
        }
    }

    /**
     * @throws UnknownProperties
     */
    private function parseAndGetParams(): array
    {
        $data = [];
        foreach ($this->argv as $condition) {
            $data[] = $this->parseCondition($condition);
        }

        return $data;
    }
}
