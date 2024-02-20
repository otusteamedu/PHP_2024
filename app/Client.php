<?php

namespace Hukimato\SocketChat;

use Exception;

class Client extends SocketClient
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $serverName = readline('Enter server name: ');
        $socketName = parent::getSocketNameFromServerName($serverName);

        $socketWrapper = new SocketWrapper();
        $socketWrapper->connect($socketName);

        while (true) {
            $message = readline('Enter message: ');

            $socketWrapper->write("{$this->name}: $message");

            $confirmation = $socketWrapper->read();
            if ($confirmation === 'closed') {
                echo "server stopped" . PHP_EOL;
                return;
            }
            echo $confirmation . PHP_EOL;
        }
    }
}
