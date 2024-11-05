<?php

declare(strict_types=1);

namespace IraYu\Hw12\View;

use IraYu\Hw12\Domain\Entity;
use PHPYurta\CLI\CLITable;

class EventsView
{
    public function __construct(
        protected array $events
    ) {
    }
    /**
     * @param Entity\Event[] $events
     * @return void
     */
    public function render(): string
    {
        $properties = [];
        foreach ($this->events as $event) {
            $properties = array_merge($properties, $event->getProperties()->getNames());
        }
        $properties = array_unique($properties);
        $table = new CLITable();
        $headers = ['Name', 'Priority', ...$properties];
        $table->setHeaders($headers);
        foreach ($this->events as $event) {
            $row = [$event->getName(), $event->getPriority()];
            foreach ($properties as $p) {
                $row[] = $event->getProperties()->getByName($p)?->getValue() ?? ' -- ';
            }
            $table->addRow($row);
        }

        return $table->getTableOutput();
    }
}
