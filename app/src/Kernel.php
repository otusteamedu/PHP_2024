<?php

declare(strict_types=1);

namespace App;

use App\Console\Command\InitializeCommand;
use App\Console\Command\SearchCommand;
use Symfony\Component\Console\Application;

final readonly class Kernel
{
    public function run(): void
    {
        $application = new Application();

        $application->add(new InitializeCommand());
        $application->add(new SearchCommand());

        $application->run();
    }
}
