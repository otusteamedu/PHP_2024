<?php

declare(strict_types=1);

namespace Dw\OtusSocketChat\Application;

use Exception;

class App
{
    protected ApplicationInterface $application;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->application = AppFactory::getApplication($_SERVER['argv'][1]);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->application->run();
    }
}
