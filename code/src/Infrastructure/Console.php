<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure;

use Exception;
use Viking311\Queue\Infrastructure\Factory\Controller\ProcessEventControllerFactory;

class Console
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $cmd = ProcessEventControllerFactory::createInstance();
        $cmd->execute();
    }
}
