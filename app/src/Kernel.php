<?php

declare(strict_types=1);

namespace App;

use App\Analytics\Console\Command\ClearEventsCommand;
use App\Analytics\Console\Command\CreateEventsCommand;
use App\Analytics\Console\Command\FindEventsByConditionsCommand;
use Symfony\Component\Console\Application;

final readonly class Kernel
{
    public function run(): void
    {
        $application = new Application();

        $application->add(new CreateEventsCommand());
        $application->add(new FindEventsByConditionsCommand());
        $application->add(new ClearEventsCommand());

        $application->run();
    }
}
