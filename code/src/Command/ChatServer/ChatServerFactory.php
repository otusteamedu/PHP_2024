<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatServer;

use Viking311\Chat\Config\Config;
use Viking311\Chat\Socket\Socket;
use Viking311\Chat\Socket\SocketException;

class ChatServerFactory
{
    /**
     * @return ChatServer
     * @throws SocketException
     */
    public static function createInstance(): ChatServer
    {
        $config = new Config();

        $socketPath = $config->get('socket_path');
        if (is_null($socketPath)) {
            throw new SocketException('Socket path is not set');
        }

        $socket = new Socket($socketPath);

        return new ChatServer($socket);
    }
}
