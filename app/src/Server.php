<?php

namespace Otus\Hw5;

class Server extends AbstractUnixSocket
{
    /**
     * @return void
     * @throws \Exception
     */
    public function startChat(): void
    {
        echo 'Re-creating socket...' . PHP_EOL;
        $this->recreate();
        echo 'Socket re-created!' . PHP_EOL;

        echo 'Creating socket...' . PHP_EOL;
        $this->create();
        echo 'Socket created!' . PHP_EOL;

        echo 'Binding socket...' . PHP_EOL;
        $this->bind();
        echo "Socket is successfully bound!" . PHP_EOL;

        $this->listen();
        echo "Server listening on socket..." . PHP_EOL;

        $client = $this->accept();

        $isRunning = true;
        while ($isRunning) {
            $message = $this->receive($client);

            if ($message === 'close') {
                socket_close($client);
                $isRunning = false;
            }

            if ($message) {
                echo "Received message: {$message}" . PHP_EOL;
            }
        }

        $this->close();
    }
}
