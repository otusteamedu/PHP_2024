<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatServer;

use Viking311\Chat\Command\CommandInterface;
use Viking311\Chat\Socket\Socket;

class ChatServer implements CommandInterface
{
    /** @var Socket  */
    private Socket $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }


    /**
     * @return void
     */
    public function execute(): void
    {
        $this->socket->create()
            ->bind(true)
            ->listen();
        fwrite(STDOUT, "Server started" . PHP_EOL);
        $this->socket->accept();
        while (true) {
            $message = $this->socket->read();
            fwrite(STDOUT, 'Received message from client: ' . $message . PHP_EOL) ;
            $this->socket->write(sprintf("Received %d bytes", strlen($message)));
        }
    }
}
