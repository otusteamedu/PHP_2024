<?php

declare(strict_types=1);

namespace Viking311\Chat\Command;

use Viking311\Chat\Command\ChatClient\ChatClient;
use Viking311\Chat\Command\ChatServer\ChatServer;
use Viking311\Chat\Config\Config;
use Viking311\Chat\Input\Reader;
use Viking311\Chat\Output\Writer;
use Viking311\Chat\Socket\Socket;

class CommandFactory
{
    /**
     * @return ChatClient
     */
    public function getChatClient(): ChatClient
    {
        $config = new Config();

        $socket = new Socket($config->socketPath);

        return new ChatClient(
            $socket,
            new Reader(STDIN, STDOUT),
            new Writer()
        );
    }

    /**
     * @return ChatServer
     */
    public function getChatServer(): ChatServer
    {
        $config = new Config();

        $socket = new Socket($config->socketPath);

        return new ChatServer(
            $socket,
            new Writer()
        );
    }
}
