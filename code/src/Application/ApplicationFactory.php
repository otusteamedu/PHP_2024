<?php

declare(strict_types=1);

namespace Viking311\Chat\Application;

use Viking311\Chat\Command\CommandFactory;

class ApplicationFactory
{
    /**
     * @return Application
     */
    static public function getApplication(): Application
    {
        return new Application(
            new CommandFactory()
        );
    }
}
