<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\EventSystem;

use DI\DependencyException;
use DI\NotFoundException;
use RailMukhametshin\Hw\Commands\AbstractCommand;

class RemoveAllEventCommand extends AbstractCommand
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function execute(): void
    {
        $this->eventRepository->removeAll();

        $this->formatter->output('Removed all events');
    }
}
