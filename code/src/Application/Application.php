<?php

declare(strict_types=1);

namespace Viking311\Chat\Application;

use Viking311\Chat\Command\ChatClient\ChatClientFactory;
use Viking311\Chat\Command\ChatServer\ChatServerFactory;
use Viking311\Chat\Socket\SocketException;

class Application
{
    /**
     * @return void
     * @throws ApplicationException
     * @throws SocketException
     */
    public function run(): void
    {
        $mode = $this->getMode();

        $cmd = match ($mode) {
            'server' => ChatServerFactory::createInstance(),
            'client' => ChatClientFactory::createInstance(),
            default => throw new ApplicationException('Unknown mode'),
        };

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
