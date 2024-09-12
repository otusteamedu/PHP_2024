<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatServer;

use Viking311\Chat\Command\CommandInterface;
use Viking311\Chat\Output\Writer;
use Viking311\Chat\Socket\Socket;

class ChatServer implements CommandInterface
{
    /** @var Socket  */
    private Socket $socket;
    /** @var Writer  */
    private Writer $writer;

    public function __construct(
        Socket $socket,
        Writer $writer
    ) {
        $this->socket = $socket;
        $this->writer = $writer;
    }


    /**
     * @return void
     */
    public function execute(): void
    {
        $this->socket->create()
            ->bind(true)
            ->listen();
        $this->writer->write("Server started" . PHP_EOL);
        $this->socket->accept();
        while (true) {
            $message = $this->socket->read();
            $this->writer->write('Received message from client: ' . $message . PHP_EOL);
            $this->socket->write(sprintf("Received %d bytes", strlen($message)));
        }
    }
}
