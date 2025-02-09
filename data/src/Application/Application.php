<?php

declare(strict_types=1);

namespace Apeskovatzkov\Hw5\Application;

use Apeskovatzkov\Hw5\ApplicationTypes;
use Apeskovatzkov\Hw5\Container;
use Psr\Container\ContainerInterface;

class Application
{
    public function __construct(
        private ApplicationTypes $appType = ApplicationTypes::Client,
        private readonly ContainerInterface $container = new Container,
    ) {
        $this->configurate();
    }

    public function run(): void
    {
        $this->container->get($this->appType->value)?->run();
    }

    private function configurate()
    {
        ob_implicit_flush();
    }
}
