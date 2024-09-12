<?php

declare(strict_types=1);

namespace Viking311\Chat\Command\ChatClient;

use Viking311\Chat\Command\CommandInterface;
use Viking311\Chat\Input\Reader;
use Viking311\Chat\Output\Writer;
use Viking311\Chat\Socket\Socket;
use Viking311\Chat\Socket\SocketException;

class ChatClient implements CommandInterface
{
    /** @var Socket  */
    private Socket $socket;
    /** @var Reader  */
    private Reader $reader;
    private Writer $writer;

    public function __construct(
        Socket $socket,
        Reader $reader,
        Writer $writer
    ) {
        $this->socket = $socket;
        $this->reader = $reader;
        $this->writer = $writer;
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
        $this->writer->write("Client started" . PHP_EOL);

        while (true) {
            $input = $this->reader->readLine('Enter your message: ');
            if (strtolower($input) == 'exit') {
                break;
            }
            $this->socket->write($input);

            $message = $this->socket->read();
            $this->writer->write('Server response: ' . $message . PHP_EOL);
        }
    }
}
