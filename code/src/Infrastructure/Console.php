<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure;

use Exception;
use Viking311\Api\Infrastructure\Factory\Command\ProcessEventCommandFactory;

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
