<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatServer;

use Viking311\Chat\Command\CommandInterface;
use Viking311\Chat\Output\Writer;
use Viking311\Chat\Socket\Socket;
use Viking311\Chat\Socket\SocketException;

class ChatServer implements CommandInterface
{
    private bool $infinityLoop = true;
    /** @var Socket  */
    private Socket $socket;
    /** @var Writer  */
    private Writer $writer;

    /**
     * @param Socket $socket
     * @param Writer $writer
     */
    public function __construct(
        Socket $socket,
        Writer $writer
    ) {
        $this->socket = $socket;
        $this->writer = $writer;
    }


    /**
     * @return void
     * @throws SocketException
     */
    public function execute(): void
    {
        $this->socket->create()
            ->bind(true)
            ->listen();
        $this->writer->write("Server started" . PHP_EOL);
        $this->socket->accept();
        do {
            $message = $this->socket->read();
            $this->writer->write('Received message from client: ' . $message . PHP_EOL);
            $this->socket->write(sprintf("Received %d bytes", strlen($message)));
        } while ($this->infinityLoop);
    }
}