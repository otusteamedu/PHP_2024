<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatClient;

use Viking311\Chat\Command\CommandInterface;
use Viking311\Chat\Socket\Socket;
use Viking311\Chat\Socket\SocketException;

class ChatClient implements CommandInterface
{
    /** @var Socket  */
    private Socket $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }


    /**
     * @return void
     * @throws SocketException
     */
    public function execute(): void
    {
        $this->socket
            ->create()
            ->connect();
        echo "Client started" . PHP_EOL;

        while (true) {
            $input = readline('Enter your message: ');
            if (strtolower($input) == 'exit') {
                break;
            }
            $this->socket->write($input);

            $message = $this->socket->read();
            fwrite(STDOUT, 'Server response: ' . $message . PHP_EOL);
        }
    }
}
