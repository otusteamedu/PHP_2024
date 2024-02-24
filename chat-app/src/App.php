<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp;

use RuntimeException;
use Sfadeev\ChatApp\Client\Client;
use Sfadeev\ChatApp\Server\Server;

class App
{
    /**
     * @param string $command
     * @return void
     *
     * @throws RuntimeException
     */
    public function run(string $command): void
    {
        $projectDir = dirname(__DIR__);

        $config = Config::create($projectDir);

        $input = fopen("php://stdin", "r");
        $output = fopen("php://stdout", "w");

        switch ($command) {
            case 'start-server':
                (new Server($config, $output))->listen();
                break;
            case 'start-client':
                (new Client($config, $input, $output))->startMessaging();
                break;
            default:
                throw new RuntimeException(sprintf('Unknown command: %s', $command));
        }
    }
}
