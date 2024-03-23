<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\EventSystem;

use DI\DependencyException;
use DI\NotFoundException;
use RailMukhametshin\Hw\Commands\AbstractCommand;
use RailMukhametshin\Hw\Repositories\EventSystem\EventRepositoryInterface;

class RemoveAllEventCommand extends AbstractCommand
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function execute(): void
    {
        $repository = $this->container->get(EventRepositoryInterface::class);
        $repository->removeAll();

        $this->formatter->output('Removed all events');
    }
}
