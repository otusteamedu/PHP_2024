<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure;

use Exception;
use Viking311\Queue\Infrastructure\Factory\Command\ProcessEventCommandFactory;

class Console
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $cmd = ProcessEventCommandFactory::createInstance();
        $cmd->execute();
    }
}
