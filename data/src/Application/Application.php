<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5\Application;

use Apeskovatzkov\Hw5\Contracts\RunnableInterface;

class Application
{
    public function __construct(
        private RunnableInterface $runnable
    ) {
    }

    public function run(): void
    {
        $this->runnable->run();
    }
}