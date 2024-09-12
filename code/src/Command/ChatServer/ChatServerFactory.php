<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatServer;

use Viking311\Chat\Config\Config;
use Viking311\Chat\Output\Writer;
use Viking311\Chat\Socket\Socket;

class ChatServerFactory
{
    /**
     * @return ChatServer
     */
    public static function createInstance(): ChatServer
    {
        $config = new Config();

        $socket = new Socket($config->socketPath);

        return new ChatServer(
            $socket,
            new Writer()
        );
    }
}
