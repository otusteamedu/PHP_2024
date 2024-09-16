<?php

declare(strict_types=1);

namespace Viking311\Chat\Application;

use Viking311\Chat\Command\CommandFactory;
use Viking311\Chat\Command\CommandInterface;
use Viking311\Chat\Socket\SocketException;

class Application
{
    public function __construct(
        private readonly CommandFactory $commandFactory
    )
    {
    }

    /**
     * @return void
     * @throws ApplicationException
     * @throws SocketException
     */
    public function run(): void
    {
        $mode = $this->getMode();

        $cmd = match ($mode) {
            'server' => $this->commandFactory->getChatServer(),
            'client' => $this->commandFactory->getChatClient(),
            default => throw new ApplicationException('Unknown mode'),
        };

        if (!($cmd instanceof CommandInterface)) {
            throw new ApplicationException('Invalid command');
        }

        $cmd->execute();
    }

    /**
     * @return mixed
     * @throws ApplicationException
     */
    private function getMode(): mixed
    {
        $argv = $_SERVER['argv'];
        if (count($argv) === 1) {
            throw new ApplicationException('Application mode not specified');
        }

        return $argv[1];
    }
}
