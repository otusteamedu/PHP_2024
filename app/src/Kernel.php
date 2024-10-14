<?php

declare(strict_types=1);

namespace App;

use App\Shared\Console\Command\CreateIndexCommand;
use App\Shared\Console\Command\DeleteIndexCommand;
use App\Shared\Console\Command\SeedIndexCommand;
use App\Shop\Console\Command\SearchBookCommand;
use Symfony\Component\Console\Application;

final readonly class Kernel
{
    public function run(): void
    {
        $application = new Application();

        $application->add(new CreateIndexCommand());
        $application->add(new DeleteIndexCommand());
        $application->add(new SeedIndexCommand());
        $application->add(new SearchBookCommand());

        $application->run();
    }
}
