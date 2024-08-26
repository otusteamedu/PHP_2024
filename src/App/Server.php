<?php

namespace Komarov\Hw5\App;

use Komarov\Hw5\Exception\AppException;
use Exception;
use Generator;

class Server
{
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->socket = new Socket();
    }

    /**
     * @throws AppException
     */
    public function start(): void
    {
        $this->socket
            ->removeSockFile()
            ->create()
            ->bind()
            ->listen();

        echo  'Socket server started...' . PHP_EOL;

        $message = $this->socketListener();

        $this->readMessages($message);
    }

    /**
     * @throws AppException
     */
    private function socketListener(): Generator
    {
        $client = $this->socket->accept();

        while (true) {
            $message = $this->socket->read($client);

            if ($message) {
                yield $message . PHP_EOL;
            } else {
                break;
            }
        }

        $this->socket
            ->removeSockFile()
            ->close()
        ;
    }

    private function readMessages($messages): void
    {
        foreach ($messages as $message) {
            echo $message;
        }
    }
}
