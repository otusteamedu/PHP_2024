<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\EventSystem;

use DI\DependencyException;
use DI\NotFoundException;
use RailMukhametshin\Hw\Commands\AbstractCommand;
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
        $params = $this->parseAndGetParams();
        $item = $this->eventRepository->getByParams($params);
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
