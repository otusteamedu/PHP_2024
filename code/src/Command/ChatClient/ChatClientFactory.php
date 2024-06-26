<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatClient;

use Viking311\Chat\Config\Config;
use Viking311\Chat\Socket\Socket;
use Viking311\Chat\Socket\SocketException;

class ChatClientFactory
{
    /**
     * @return ChatClient
     */
    public static function createInstance(): ChatClient
    {
        $config = new Config();

        $socketPath = $config->getSocketPath();

        $socket = new Socket($socketPath);

        return new ChatClient($socket);
    }
}
