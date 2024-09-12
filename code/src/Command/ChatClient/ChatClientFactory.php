<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatClient;

use Viking311\Chat\Config\Config;
use Viking311\Chat\Input\Reader;
use Viking311\Chat\Output\Writer;
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

        $socket = new Socket($config->socketPath);

        return new ChatClient(
            $socket,
            new Reader(),
            new Writer()
        );
    }
}
